<?php

use Zipcode\Zipcode;

class PetRecord extends Eloquent{
    protected $table = 'pet_records';

    public function __construct($pet_data = null){
        if($pet_data){
            $this->store($pet_data);
        }
        parent::__construct();
    }

    public function store($pet_data){
        $this->pet_id = $pet_data['id']['$t'];

        if($record = self::alreadyExists($this->pet_id)){
            return $record;
        }

        $this->name = $pet_data['name']['$t'];
        if(isset($pet_data['breeds']['breed'][0]['$t'])){
            $this->breed = $pet_data['breeds']['breed'][0]['$t'];
        }
        else{
            $this->breed = $pet_data['breeds']['breed']['$t'];
        }

        if(isset($pet_data['description']['$t'])){
            $this->description = $pet_data['description']['$t'];
        }
        $this->photos = '';
        if(isset($pet_data['media']['photos']['photo'])){
            foreach($pet_data['media']['photos']['photo'] as $photo){
                if($photo['@size'] == 'x'){
                    if($this->photos != ''){
                        $this->photos .= '|p|';
                    }
                    $this->photos .= $photo['$t'];
                }
            }
        }
        $this->animal = strtolower($pet_data['animal']['$t']);
        $this->zipcode = $pet_data['contact']['zip']['$t'];

        $this->save();
    }

    public function stillAvailable(){
        $this->touch();
    }

    public static function alreadyExists($pet_id){
        return self::where('pet_id', '=', $pet_id)->first();
    }

    public static function getNearby($zipcode = null, $animal = null, $offset = null){
        if($zipcode == null){
            App::about(404, 'No Zipcode Provided.');
        }
        $nearby_zip_codes = Zipcode::near($zipcode, 25, false);

        $records = self::whereIn('zipcode', $nearby_zip_codes);
        if($animal){
            $records->where('animal', '=', $animal);
        }
        if($offset){
            $records->skip($offset);
        }
        $records = $records->take(25)->get();

        if(sizeof($records) < 25){
            $finder = new PetFinder();
            $pet_data = $finder->findNearby($zipcode, $animal, $offset);

            foreach($pet_data as $data){
                new self($data);
            }
            $records = self::whereIn('zipcode', $nearby_zip_codes);
            if($animal){
                $records->where('animal', '=', $animal);
            }
            if($offset){
                $records->skip($offset);
            }
            $records = $records->take(25)->get();
        }
        return $records;
    }
}