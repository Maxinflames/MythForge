<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game_Type extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'game_type';
    public $timestamps = false;
    protected $fillable = [
        'game_type_id', 'game_type_title', 'game_type_description'
    ];
    public function getRouteKeyName()
    {
        return 'game_type_id';
    }
}
