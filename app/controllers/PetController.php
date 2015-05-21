<?php

class PetController extends BaseController {

    public function getNearbyJSON($zipcode = null, $animal = null, $offset = null){
        $pet_records = PetRecord::getNearby($zipcode, $animal, $offset);
        return json_encode($pet_records);
    }

    public function getTopJSON($rating_slug = null, $offset = null){
        $rating = Rating::where('rating_slug', '=', $rating_slug)->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->skip($offset)->take(25)->get();
        $pets = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $pets[] = new Pet($record);
            $pets[$key]->total_votes = $id->total_votes;
        }

        return json_encode($pets);
    }

    function getTop($rating_slug){
        $rating = Rating::where('rating_slug', '=', $rating_slug)->first();
        $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();
        $pets = [];
        foreach($top_ids as $key=>$id){
            $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
            $pets[] = new Pet($record);
            $pets[$key]->total_votes = $id->total_votes;
        }


        return Redirect::to('top/'.$rating_slug.'/'.$pets[0]->pet_id)->with(array(
            'pets' => $pets
        ));
    }

    function showTop($rating_slug, $pet_id){
        if(!Session::has('pets')){
            $rating = Rating::where('rating_slug', '=', $rating_slug)->first();
            $top_ids = Vote::select(DB::raw('pet_id, count(rating_id) as total_votes'))->where('rating_id', '=', $rating->id)->groupBy('pet_id')->orderBy('total_votes', 'DESC')->take(25)->get();

            $current_pet = PetRecord::where('pet_id', '=', $pet_id)->first();
            $pets[] = new Pet($current_pet);

            foreach($top_ids as $key=>$id){
                if($id->pet_id != $current_pet->pet_id){
                    $record = PetRecord::where('pet_id', '=', $id->pet_id)->first();
                    $pets[] = new Pet($record);
                    $pets[$key]->total_votes = $id->total_votes;
                }
            }
        }
        else{
            $pets = Session::pull('pets');
        }

        $ratings = Rating::all();
        $votes = Session::get('votes', null);

        return View::make('pet')->with(array(
            'pets' => $pets,
            'ratings' => $ratings,
            'votes' => $votes,
            'rating_slug' => $rating_slug
        ));
    }

    public function getNearby()
    {
        $zipcode = Input::get('zipcode');
        // Invalid Zipcodes Return to same page
        if(Zipcode::where('zip_code', '=', $zipcode)->count() < 1){
            return Redirect::back();
        }
        $animal = Input::get('animal');
        if($animal == 'all'){
            $animal = null;
        }
        $pet_records = PetRecord::getNearby($zipcode, $animal);
        $pets = [];

        foreach($pet_records as $record){
            $pets[] = new Pet($record);
        }

        $query = array('zipcode' => $zipcode, 'animal' => $animal);

        return Redirect::to('pet/'.$pets[0]->pet_id)->with(array(
            'pets' => $pets,
            'query' => $query
        ));
    }

    public function showNearby($pet_id){
        if(!Session::has('pets')){
            $current_pet = PetRecord::where('pet_id', '=', $pet_id)->first();
            $pet_records = PetRecord::getNearby($current_pet->zipcode, $current_pet->animal);
            $pets[] = new Pet($current_pet);

            foreach($pet_records as $record){
                if($current_pet->id != $record->id){
                    $pets[] = new Pet($record);
                }
            }

            $query = array('zipcode' => $current_pet->zipcode, 'animal' => $current_pet->animal);
        }
        else{
            $pets = Session::pull('pets');
            $query = Session::pull('query');
        }

        $ratings = Rating::all();
        $votes = Session::get('votes', null);

        return View::make('pet')->with(array(
            'pets' => $pets,
            'ratings' => $ratings,
            'query' => $query,
            'votes' => $votes
        ));
    }

    public function getStatus($pet_id){
        $pet_record = PetRecord::where('pet_id', '=', $pet_id)->first();
        $pet = new Pet($pet_record);
        $available =  $pet->isAvailable();

        if($available){
            $pet_record->stillAvailable();
            return $pet_record->updated_at->format('M d, Y');
        }
        return 0;
    }
}