<?php

use Protestr\Forms\CreateUpdate;
use Protestr\Forms\FormValidationException;

class UpdatesController extends \BaseController {

	public function __construct(CreateUpdate $createUpdateForm)
	{
		$this->beforeFilter('auth', ['except' => 'show', 'index']);
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->createUpdateForm = $createUpdateForm;
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
		if (!Session::get('protest')) return Redirect::route('home');
		$protest = Session::get('protest');
		return View::make('updates.create', compact('protest'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = $this->createUpdateForm->sanitize(Input::all());
		$protest = Protest::findOrFail($data['protest_id']);

		if (!Auth::user() || Auth::user()->id !== $protest->user->id) {
			return Redirect::route('protests.show', $protest->id);
		}

		try
		{
			$this->createUpdateForm->validate($data);
		}
		catch (FormValidationException $e)
		{
			return Redirect::route('updates.create')->withInput()->withErrors($e)->with(['protest'=>$protest]);
		}

		if ($data['protest_id'] != $protest->id)
		{
			$message = [
				'class' => 'danger',
				'message' => '<strong>Oops!</strong> Something went wrong. Please try again.'
			];

			return Redirect::route('protests.show', $protest->id)->with(compact('message'));
		}

		$update = Update::create([
			'protest_id' => $data['protest_id'],
			'title' => $data['title'],
			'body' => $data['body']
		]);

		return Redirect::route('protests.show', $protest->id);
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
