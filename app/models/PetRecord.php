<?php

class PetRecord{

    public function __construct($pet_data){
        $this->data = $pet_data;
        $this->breed = $pet_data['breeds']['breed'];
        $this->name = $pet_data['name'];
        $this->description = $pet_data['description'];
        $this->contact = $pet_data['contact'];
        $this->photos = $pet_data['media']['photos']['photo'];
        $this->pet_id = $pet_data['id'];
        $this->animal = $pet_data['animal'];
    }
}