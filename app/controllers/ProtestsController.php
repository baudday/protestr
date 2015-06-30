<?php

use Carbon\Carbon;
use GeoIp2\Database\Reader;
use Protestr\Forms\CreateProtest;
use Protestr\Location;

class ProtestsController extends \BaseController {

	protected $createProtestForm;


	function __construct(CreateProtest $createProtestForm)
	{
		$this->beforeFilter('auth', ['except' => ['show', 'index']]);
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->createProtestForm = $createProtestForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Input::get('format') == 'json')
		{
			$protests['global'] = Protest::popular()->upcoming()->take(3)->get();
			$meta = [
				'badLocation' => false,
				'noResults' => false,
				'noLocal' => false
			];
		}

		// Geolocation is king
		if (Input::get('lat') && Input::get('lon')) {
			$lat = Input::get('lat');
			$lon = Input::get('lon');
			$location = [
				'latitude' => $lat,
				'longitude' => $lon
			];
		}

		// Try GeoIP if geolocation fails
		else {
			try {
				$ip = App::environment() == 'local' ? '68.38.23.38' : Request::getClientIp();
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
			catch (GeoIp2\Exception\AddressNotFoundException $e)
			{
				if (Input::get('format') == 'json')
				{
					$protests['local'] = [];
					$meta['badLocation'] = true;
					$meta['noResults'] = $protests['global']->count() < 1;
					return compact('meta', 'protests', 'location');
				}

				return View::make('protests.index');
			}
		}


		if (Input::get('format') == 'json') {
			$local = Protest::near($lat, $lon)->popular()->upcoming()->take(3)->get();
			$protests['local'] = $local;
			$meta['noLocal'] = $local->count() < 1;
			$meta['noResults'] = $meta['noLocal'] && $protests['global']->count() < 1;

			return compact('meta', 'protests', 'location');
		}

		return View::make('protests.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('protests.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = $this->createProtestForm->sanitize(Input::all());
		$this->createProtestForm->validate($data);

		$data['user_id'] = Auth::user()->id;
		$data['when_date'] = Carbon::createFromTimeStamp(strtotime($data['date']));

		if ($data['time'])
			$data['when_time'] = Carbon::createFromTimeStamp(strtotime($data['time'] . ' ' . $data['timezone']));

		if ($data['address'] || $data['city'] || $data['state']) {
			$location = Location::geocode($data['address'] . " " . $data['city'] . ", " . $data['state']);
			$coords = $location->results[0]->geometry->location;
			$data['latitude'] = $coords->lat;
			$data['longitude'] = $coords->lng;
		}

		unset($data['date'], $data['time'], $data['timezone']);
		$protest = Protest::create($data);
		$protest->attendees()->attach(Auth::user()->id);
		return Redirect::route('protests.show', ['id' => $protest->id]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$protest = Protest::with('attendees', 'updates', 'comments')->findOrFail($id);
		$comments = $protest->comments()->relevant()->with('replies')->get();
		$creator = $protest->user;
		return View::make('protests.show', compact('protest', 'creator', 'comments'));
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
		$input = Input::all();
		$protest = Protest::find($id);
		$protest->toggleAttending(Auth::user()->id);
		return Redirect::back();
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


}
