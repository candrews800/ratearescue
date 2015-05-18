<?php

class PetFinder {

    public function __construct(){
        $private = require app_path().'/config/private.php';
        $this->key = $private['api_key'];
    }

    public function find($zipcode = null, $animal = null, $offset){
        if($zipcode == null){
            $zipcode = 32817;
        }
        $add_text = '';
        if($animal){
            $add_text = '&animal='.$animal;
        }
        if($offset){
            $add_text = '&offset='.$offset;
        }
        $request_url = 'http://api.petfinder.com/pet.find?key='.$this->key.'&location='.$zipcode.'&format=json'.$add_text;
        $data = file_get_contents($request_url);

        return $this->processResults($data);
    }

    public function getStatus($pet_id){
        $request_url = 'http://api.petfinder.com/pet.get?key='.$this->key.'&format=json&id='.$pet_id;
        $data = file_get_contents($request_url);

        $data = json_decode($data, true);
        return $data['petfinder']['pet']['status']['$t'];
    }

    public function findNearby($zipcode, $animal, $offset){
        return $this->find($zipcode, $animal, $offset);
    }

    public function processResults($data){
        $data = json_decode($data, true);

        return $data['petfinder']['pets']['pet'];
    }
}
