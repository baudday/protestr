<?php namespace Api;

use Protestr\Location;

class LocationController extends \BaseController {

    public function geocode()
    {
        $meta['match'] = false;
        $meta['query'] = \Input::get('address');

        $location = Location::geocode(\Input::get('address'));

        if (isset($location->results[0])) {
            $meta['match'] = true;
            $meta['address'] = $location->results[0]->formatted_address;
            $coords = $location->results[0]->geometry->location;
            $coordinates['latitude'] = $coords->lat;
            $coordinates['longitude'] = $coords->lng;
        }

        return compact('meta', 'coordinates');
    }
}
