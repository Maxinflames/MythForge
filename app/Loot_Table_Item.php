<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loot_table_Item extends Model
{
    /**
     * the attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'loot_table_item';
    public $timestamps = false;
    protected $fillable = [
        'loot_table_item_id', 'loot_table_id', 'item_id', 'loot_table_item_dice_count', 'loot_table_item_roll',  'loot_table_item_count', 'loot_table_item_weight'
    ];
    public function getRouteKeyName()
    {
        return 'loot_table_item_id';
    }
}
