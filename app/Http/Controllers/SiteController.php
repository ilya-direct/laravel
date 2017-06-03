<?php

namespace App\Http\Controllers;

use App\Pages;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Facades\Agent;
use PulkitJalan\GeoIP\Facades\GeoIP;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SiteController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setStat($id)
    {
        $os = Agent::platform();
        $os = empty($os) ? 'unknown' : $os;

        $browser = Agent::browser();
        $browser = empty($browser) ? 'unknown' : $browser;

        $referer = Request::server('HTTP_REFERER');
        $referer = empty($referer) ? 'unknown' : parse_url($referer)['host'];

        $city = GeoIP::getCity();
        $city = empty($city) ? 'unknown' : $city;


        $ip = Request::ip();
        $sessionId = Session::getId();

        // Статистика по странице
        $this->setRedisStat('page:' . $id, $browser, $os, $referer, $city, $ip, $sessionId);
        // Общая статистика
        $this->setRedisStat('total', $browser, $os, $referer, $city, $ip, $sessionId);
    }

    protected function setRedisStat($pageName, $browser, $os, $referer, $city, $ip, $sessionId)
    {
        Redis::pipeline(function ($pipe) use ($pageName, $browser, $os, $referer, $city, $ip, $sessionId) {
            /** @var $pipe \Redis */
            $pipe->sAdd($pageName . ':browsers', $browser);
            $pipe->sAdd($pageName . ':oses', $os);
            $pipe->sAdd($pageName . ':referers', $referer);
            $pipe->sAdd($pageName . ':cities', $city);

            $pipe->sAdd($pageName . ':browser:' . $browser . ':ip' , $ip);
            $pipe->sAdd($pageName . ':browser:' . $browser . ':session' , $sessionId);
            $pipe->incr($pageName . ':browser:' . $browser . ':hits');

            $pipe->sAdd($pageName . ':os:' . $os . ':ip' , $ip);
            $pipe->sAdd($pageName . ':os:' . $os . ':session' , $sessionId);
            $pipe->incr($pageName . ':os:' . $os . ':hits');

            $pipe->sAdd($pageName . ':referer:' . $referer . ':ip' , $ip);
            $pipe->sAdd($pageName . ':referer:' . $referer . ':session' , $sessionId);
            $pipe->incr($pageName . ':referer:' . $referer . ':hits');

            $pipe->sAdd($pageName . ':city:' . $city . ':ip' , $ip);
            $pipe->sAdd($pageName . ':city:' . $city . ':session' , $sessionId);
            $pipe->incr($pageName . ':city:' . $city . ':hits');
        });
    }

    public function index()
    {
        $this->setstat(0);

        return view('index', ['pages' => Pages::get()]);
    }

    public function showPage($id)
    {
        $pages = Pages::get();
        if (isset($pages[$id])) {
            $this->setstat($id);
            return view('pages/' . $id, ['id' => $id, 'title' => $pages[$id]]);
        } else {
            throw new HttpException(404);
        }
    }

}
