<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model{
    protected $table = 'votes';
    public $timestamps = false;

    public static function cast($pet_id, $rating_id){
        $vote = new self;
        $vote->rating_id = $rating_id;
        $vote->pet_id = $pet_id;
        return $vote->save();
    }
}