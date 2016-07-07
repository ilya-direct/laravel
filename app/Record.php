<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Record
 *
 * @property integer $id
 * @property string $date
 * @property integer $sum
 * @property integer $item_id
 * @property integer $column_id
 * @property-read \App\Item $item
 * @method static \Illuminate\Database\Query\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Record whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Record whereSum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Record whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Record whereColumnId($value)
 * @mixin \Eloquent
 */
class Record extends Model
{
    protected $table = 'record';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
