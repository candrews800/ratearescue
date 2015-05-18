<?php

class HomeController extends BaseController {

	public function index()
	{
        $cute_rating = Rating::where('rating_slug', '=', 'cute')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $cute_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(3)->get();
        $top_cute = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_cute[] = new Pet($record);
            $top_cute[$key]->total_votes = $id->total_votes;
        }

        $love_rating = Rating::where('rating_slug', '=', 'love')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $love_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(3)->get();
        $top_love = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_love[] = new Pet($record);
            $top_love[$key]->total_votes = $id->total_votes;
        }

        $tuff_rating = Rating::where('rating_slug', '=', 'tuff')->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $tuff_rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(3)->get();
        $top_tuff = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $top_tuff[] = new Pet($record);
            $top_tuff[$key]->total_votes = $id->total_votes;
        }


		return View::make('index')->with(array(
            'top_cute' => $top_cute,
            'top_love' => $top_love,
            'top_tuff' => $top_tuff
        ));
	}
}
