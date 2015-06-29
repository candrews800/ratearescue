<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Vote;
use App\PetRecord;
use App\Pet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomeController extends Controller {

	public function index()
	{
        $cute_rating = Rating::where('rating_slug', '=', 'cute')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $cute_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();
        $top_cute = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_cute[] = new Pet($record);
            $top_cute[$key]->total_votes = $id->total_votes;
        }

        $tiny_rating = Rating::where('rating_slug', '=', 'tiny')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $tiny_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();
        $top_tiny = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_tiny[] = new Pet($record);
            $top_tiny[$key]->total_votes = $id->total_votes;
        }

        $tuff_rating = Rating::where('rating_slug', '=', 'tuff')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $tuff_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();
        $top_tuff = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_tuff[] = new Pet($record);
            $top_tuff[$key]->total_votes = $id->total_votes;
        }

        $happy_rating = Rating::where('rating_slug', '=', 'happy')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $happy_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();
        $top_happy = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_happy[] = new Pet($record);
            $top_happy[$key]->total_votes = $id->total_votes;
        }


		return View::make('index')->with(array(
            'top_cute' => $top_cute,
            'top_tiny' => $top_tiny,
            'top_tuff' => $top_tuff,
            'top_happy' => $top_happy
        ));
	}
}
