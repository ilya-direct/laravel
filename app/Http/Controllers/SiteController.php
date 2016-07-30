<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Pages;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Facades\Agent;
use PulkitJalan\GeoIP\Facades\GeoIP;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SiteController extends Controller
{

    protected function setStat($id)
    {
        $os = Agent::platform();
        $os = empty($os) ? 'unknown' : $os;

        $browser = Agent::browser();
        $browser = empty($browser) ? 'unknown' : $browser;

        $referer = Request::server('HTTP_REFERER');
        $referer = empty($referer) ? 'unknown' : parse_url($referer)['host'];

//        $city = GeoIP::getCity();
        $city = 'unknown';
        $city = empty($city) ? 'unknown' : $city;


        $ip = Request::ip();
        $sessionId = Session::getId();
        // hits

        $redis = app()->make('redis');

//        $redis->sAdd('pages', $id);

        $redis->sAdd('page:' . $id . ':browsers', $browser);
        $redis->sAdd('page:' . $id . ':oses', $os);
        $redis->sAdd('page:' . $id . ':referers', $referer);
        $redis->sAdd('page:' . $id . ':cities', $city);

        $redis->sAdd('page:' . $id . ':browser:' . $browser . ':ip' , $ip);
        $redis->sAdd('page:' . $id . ':browser:' . $browser . ':session' , $sessionId);
        $redis->incr('page:' . $id . ':browser:' . $browser . ':hits');

        $redis->sAdd('page:' . $id . ':os:' . $os . ':ip' , $ip);
        $redis->sAdd('page:' . $id . ':os:' . $os . ':session' , $sessionId);
        $redis->incr('page:' . $id . ':os:' . $os . ':hits');

        $redis->sAdd('page:' . $id . ':referer:' . $referer . ':ip' , $ip);
        $redis->sAdd('page:' . $id . ':referer:' . $referer . ':session' , $sessionId);
        $redis->incr('page:' . $id . ':referer:' . $referer . ':hits');

        $redis->sAdd('page:' . $id . ':city:' . $city . ':ip' , $ip);
        $redis->sAdd('page:' . $id . ':city:' . $city . ':session' , $sessionId);
        $redis->incr('page:' . $id . ':city:' . $city . ':hits');

        $this->setGeneralStat($browser, $os, $referer, $city, $ip, $sessionId);
    }

    protected function setGeneralStat($browser, $os, $referer, $city, $ip, $sessionId)
    {
        $redis = app()->make('redis');

        $redis->sAdd('total:browsers', $browser);
        $redis->sAdd('total:oses', $os);
        $redis->sAdd('total:referers', $referer);
        $redis->sAdd('total:cities', $city);

        $redis->sAdd('total:browser:' . $browser . ':ip' , $ip);
        $redis->sAdd('total:browser:' . $browser . ':session' , $sessionId);
        $redis->incr('total:browser:' . $browser . ':hits');

        $redis->sAdd('total:os:' . $os . ':ip' , $ip);
        $redis->sAdd('total:os:' . $os . ':session' , $sessionId);
        $redis->incr('total:os:' . $os . ':hits');

        $redis->sAdd('total:referer:' . $referer . ':ip' , $ip);
        $redis->sAdd('total:referer:' . $referer . ':session' , $sessionId);
        $redis->incr('total:referer:' . $referer . ':hits');

        $redis->sAdd('total:city:' . $city . ':ip' , $ip);
        $redis->sAdd('total:city:' . $city . ':session' , $sessionId);
        $redis->incr('total:city:' . $city . ':hits');
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
