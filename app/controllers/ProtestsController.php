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
		// Geolocation is king
		if (Input::get('lat') && Input::get('lon')) {
			$lat = Input::get('lat');
			$lon = Input::get('lon');
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
					'city'			=> $row->city->name,
					'state'			=> $row->mostSpecificSubdivision->isoCode
				];
			}
			// All else failed, ask the user to enter their location
			catch (GeoIp2\Exception\AddressNotFoundException $e)
			{
				if (Input::get('format') == 'json')
				{
					$response = Response::make([
					'error' => "Couldn't determine location"
					], 500);
					return $response;
				}

				return View::make('protests.index');
			}
		}


		if (Input::get('format') == 'json') {
			$protests = Protest::near($lat, $lon)->popular()->upcoming()->get();
			$top = $protests->shift();
			return compact('protests', 'top', 'location');
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
		$protest = Protest::with('attendees')->findOrFail($id);
		return View::make('protests.show', compact('protest'));
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
		if (isset($input['attendees'])) {
			$input['attendees'] == 'add'
				? $protest->attendees()->attach(Auth::user()->id)
				: $protest->attendees()->detach(Auth::user()->id);
		}
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
