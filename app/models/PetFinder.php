<?php

class PetFinder {

    public function __construct(){
        $private = require app_path().'/config/private.php';
        $this->key = $private['api_key'];
    }

    public function find($zipcode = null, $animal = null){
        if($zipcode == null){
            $zipcode = 33024;
        }
        $request_url = 'http://api.petfinder.com/pet.find?key='.$this->key.'&location='.$zipcode.'&format=json';
        $data = file_get_contents($request_url);

        return $this->processResults($data);
    }

    public function findDogs($zipcode = null){
        return $this->find($zipcode, 'dog');
    }

    public function findCats($zipcode = null){
        return $this->find($zipcode, 'cat');
    }

    public function processResults($data){
        $data = json_decode($data, true);

        $pet_data = $data['petfinder']['pets']['pet'];
        $pet_records = array();
        foreach($pet_data as $pet){
            $pet_records[] = new PetRecord($pet);
        }

        return $pet_records;
    }
}
