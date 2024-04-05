<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loot_Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'loot_group';
    public $timestamps = false;
    protected $fillable = [
        'loot_group_id', 'user_id', 'loot_group_description'
    ];
    public function getRouteKeyName()
    {
        return 'loot_group_id';
    }

}
