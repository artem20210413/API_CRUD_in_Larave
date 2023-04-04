<?php

namespace Database\Seeders;

use App\Models\Continents;
use App\Models\Countries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ContinentsCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('http://country.io/names.json');

        if ($response->ok()) {
            $dataCountry = $response->json();
            dump('Countries table has been filled from API!');
        } else {
            dd('Error country: cannot get data from API.');
        }

        $response = Http::get('http://country.io/continent.json');

        if ($response->ok()) {
            $dataContinent = $response->json();
            dump('Country table has been filled from API!');
        } else {
            dd('Error country: cannot get data from API.');
        }

        foreach ($dataContinent as $isoCodeCountry => $isoCode) {
            $ThiName = '---';

            if (!Continents::where('iso_code', $isoCode)->first())
                Continents::create([
                    'iso_code' => $isoCode
                ]);

            foreach ($dataCountry as $code => $name) {
                if ($code === $isoCodeCountry) {
                    $ThiName = $name;
                    break;
                }
            }

            Countries::create([
                'iso_code' => $isoCodeCountry,
                'iso_code_continent' => $isoCode,
                'name' => $ThiName,
            ]);
        }
    }
}
