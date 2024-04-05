<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loot_Table extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'loot_table';
    public $timestamps = false;
    protected $fillable = [
        'loot_table_id', 'user_id', 'loot_table_description'
    ];
    public function getRouteKeyName()
    {
        return 'loot_table_id';
    }
}
