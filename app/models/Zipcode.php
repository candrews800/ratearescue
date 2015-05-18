<?php

class Zipcode extends Eloquent
{
    protected $table = 'zips';

    public static function getCloseZips($zipcode, $distance = 5){
        $zip = self::where('zip_code', '=', $zipcode)->first();

        $zip_codes = self::select(DB::raw('( 3959 * acos( cos( radians('.$zip->lat.') ) * cos( radians( lat ) )
                                            * cos( radians(lon) - radians('.$zip->lon.')) + sin(radians('.$zip->lat.'))
                                            * sin( radians(lat)))) AS distance, zip_code '))
            ->having('distance', '<', $distance)
            ->distinct()
            ->get();

        // Return Array of Zipcodes strings, not the Zipcode object
        $zips = [];
        foreach($zip_codes as $zip_code){
            $zips[] = $zip_code->zip_code;
        }
        return $zips;
    }
}