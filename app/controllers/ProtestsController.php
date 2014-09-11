<?php

use Carbon\Carbon;
use Protestr\Forms\CreateProtest;

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
		$protests = Protest::popular()->upcoming()->get();
		$top = $protests->shift();
		return View::make('protests.index', compact('protests', 'top'));
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
