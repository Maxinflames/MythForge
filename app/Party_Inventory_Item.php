<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party_Inventory_Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'party_inventory_item';
    public $timestamps = false;
    protected $fillable = [
        'party_inventory_item_id', 'party_inventory_id', 'item_id', 'item_quantity'
    ];
    public function getRouteKeyName()
    {
        return 'party_inventory_item_id';
    }
}
