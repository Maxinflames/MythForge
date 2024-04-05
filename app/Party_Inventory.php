<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party_Inventory extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $table = 'party_inventory';
   public $timestamps = false;
   protected $fillable = [
    'party_inventory_id', 'campaign_id'
   ];
   public function getRouteKeyName()
   {
       return 'party_inventory_id';
   }
}
