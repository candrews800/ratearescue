<?php

class RatingsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('ratings')->delete();

        Rating::create(['rating_slug' => 'cute', 'rating_text' => 'very cute']);
        Rating::create(['rating_slug' => 'tiny', 'rating_text' => 'lil tiny']);
        Rating::create(['rating_slug' => 'tuff', 'rating_text' => 'so tuff']);
        Rating::create(['rating_slug' => 'happy', 'rating_text' => 'super happy']);
    }

}