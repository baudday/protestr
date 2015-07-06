<?php namespace Api;

use GeoIp2\Database\Reader;
use Protestr\Location;

class ProtestsController extends \BaseController {

	const DEFAULT_OFFSET = 0;
	const DEFAULT_LIMIT = 10;
	const UPPER_LIMIT = 100;


	/**
	 * Return protests that match query
	 *
	 * @param: bool $global optional should global results be included
	 * @param: bool $local optional should local results be included
	 * @param: int $glob_limit optional how many global results
	 * @param: int $glob_offset optional global results offset
	 * @param: int $loc_limit optional how many local results
	 * @param: int $loc_offset optional local results offset
	 * @param: double $lat optional user's latitude
	 * @param: double $lon optional user's longitude
	 * @param: string $sort optional how to sort the results
	 *
	 * @return JSON Response
	 */
	public function index()
	{
		$global = filter_var(\Input::get('global'), FILTER_VALIDATE_BOOLEAN);
		$local = filter_var(\Input::get('local'), FILTER_VALIDATE_BOOLEAN);
		$sort = \Input::get('sort');

		$meta = [
			'badLocation' => false,
			'noResults' => true,
			'noLocal' => false
		];

		if ($global) {
			$limit = $this->get_limit(\Input::get('glob_limit'));
			$offset = $this->get_offset(\Input::get('glob_offset'));

			if ($sort == 'newest') {
				$protests['global'] = \Protest::upcoming()->take($limit)->offset($offset)->orderBy('created_at', 'desc')->get();
			}
			else {
				$protests['global'] = \Protest::popular()->upcoming()
					->take($limit)->offset($offset)->get();
			}

			$meta['noResults'] = $meta['noResults'] && $protests['global']->count() < 1;
		}

		if ($local) {
			$limit = $this->get_limit(\Input::get('loc_limit'));
			$offset = $this->get_offset(\Input::get('loc_offset'));

			// Geolocation is king
			if (\Input::get('lat') && \Input::get('lon')) {
				$lat = \Input::get('lat');
				$lon = \Input::get('lon');
				$location = [
					'latitude' => $lat,
					'longitude' => $lon
				];
			}

			// Try GeoIP if geolocation fails
			else {
				try {
					$ip = \App::environment() == 'local' ? '68.38.23.38' : \Request::getClientIp();
					$reader = new Reader('/usr/local/share/GeoIP/GeoLite2-City.mmdb');
					$row = $reader->city($ip);
					$lat = $row->location->latitude;
					$lon = $row->location->longitude;
					$location = [
						'latitude'			=> $lat,
						'longitude'			=> $lon
					];
				}
				// All else failed, ask the user to enter their location
				catch (\GeoIp2\Exception\AddressNotFoundException $e)
				{
					$protests['local'] = [];
					$meta['badLocation'] = true;
					return compact('meta', 'protests', 'location');
				}
			}

			if ($sort == 'newest') {
				$protests['local'] = \Protest::near($lat, $lon)->upcoming()
					->take($limit)->offset($offset)->orderBy('created_at', 'desc')->get();
			}
			else {
				$protests['local'] = \Protest::near($lat, $lon)->popular()->upcoming()
					->take($limit)->offset($offset)->get();
			}

			$meta['noLocal'] = $protests['local']->count() < 1;
			$meta['noResults'] = $meta['noResults'] && $meta['noLocal'];
		}

		return compact('meta', 'protests', 'location');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function get_limit($limit)
	{
		return
			$limit > 0 ?
				$limit <= self::UPPER_LIMIT ? abs($limit) : self::UPPER_LIMIT
			: self::DEFAULT_LIMIT;
	}

	private function get_offset($offset)
	{
		return $offset !== null ? $offset : self::DEFAULT_OFFSET;
	}


}
