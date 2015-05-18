<?php

class RatingsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('ratings')->delete();

        Rating::create(['rating_slug' => 'cute', 'rating_text' => 'much cute']);
        Rating::create(['rating_slug' => 'love', 'rating_text' => 'needs luv']);
        Rating::create(['rating_slug' => 'tuff', 'rating_text' => 'so tuff']);
    }

}