<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Vote;
use Illuminate\Support\Facades\Session;

class VoteController extends Controller{

    public function cast($pet_id, $rating_slug){
        $rating = Rating::where('rating_slug', '=', $rating_slug)->first();
        if(Vote::cast($pet_id, $rating->id)){
            Session::push('votes', array('pet_id' => $pet_id, 'slug' => $rating->rating_slug));
            return 1;
        }
        return 0;
    }
}