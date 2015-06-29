<?php

namespace App;

class Pet{

    public $name, $description, $animal, $photos, $breed, $pet_id, $last_available;

    public function __construct(PetRecord $record = null){
        if($record == null){
            return 0;
        }
        $this->photos = $record->photos;
        $this->name = $record->name;
        $this->description = $record->description;
        $this->animal = $record->animal;
        $this->pet_id = $record->pet_id;
        $this->breed = $record->breed;
        $this->zipcode = $record->zipcode;
        $this->last_available = $record->updated_at->format('M d, Y');
    }

    public function getNameAttribute($value){
        return ucfirst(strtolower($value));
    }

    public function getDescriptionAttribute($value){
        return $value;
    }

    public function getPhotos($count = null){
        $photos = explode('|p|', $this->photos);
        if($count){
            $photos = array_chunk($photos, $count);
        }
        return $photos;
    }

    public function getAnimalAttribute($value){
        return ucfirst(strtolower($value));
    }

    public function isAvailable(){
        $finder = new PetFinder();
        $status = $finder->getStatus($this->pet_id);
        if($status == 'A'){
            return 1;
        }
        return 0;
    }
}