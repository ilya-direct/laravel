<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Item
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereName($value)
 * @method static $this find(int $id)
 */
class Item extends Model
{
    protected $table = 'item';

}
