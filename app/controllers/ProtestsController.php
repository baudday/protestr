<?php

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
		//
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
		// Protest::create($data);
		return $data;
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


}
