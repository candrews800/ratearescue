<?php

class HomeController extends BaseController {

	public function index()
	{
        $pet_search = new PetFinder();
        $dogs = $pet_search->findDogs(33024);

		return View::make('index')->with(array(
            'dogs' => $dogs
        ));
	}

}
