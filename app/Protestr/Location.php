<?php namespace Protestr;

use \Guzzle\Http\Client;

class Location {

  const API_KEY = 'AIzaSyC-fp-wfsRUi-JeIiaHGFuXNjsCHe1pWVU';
  const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

  public static function geocode($q)
  {
    $query_data = [
    'address' => $q,
    'key' => self::API_KEY
    ];

    $client = new Client();
    $res = $client->get(self::API_URL, [], ['query' => $query_data])->send();

    return json_decode($res->getBody());
  }

}
