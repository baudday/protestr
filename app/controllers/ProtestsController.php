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
		$topics = \Topic::all();
		return View::make('protests.index', compact('topics'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = Topic::all()->toArray();
		$topics[''] = 'Select Topic';
		foreach ($data as $key => $value) {
			$topics[$value['id']] = $value['name'];
		}

		return View::make('protests.create', compact('topics'));
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

		$data['topic_id'] = $data['topic'];

		unset($data['date'], $data['time'], $data['timezone'], $data['topic']);
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
