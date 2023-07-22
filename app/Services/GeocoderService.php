<?php

namespace App\Services;

class GeocoderService
{
    public function getCoordinates($address): array
    {
        $API_KEY = env('GEOCODER_API_KEY');
        $url = "https://geocode-maps.yandex.ru/1.x/?format=json&apikey="
            . urlencode($API_KEY) . "&geocode=" . urlencode($address);

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $coordinates
            = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        return explode(' ', $coordinates);
    }
}
