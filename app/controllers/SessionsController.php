<?php

use Protestr\Forms\Login;
use Protestr\Forms\FormValidationException;

class SessionsController extends \BaseController {

	protected $loginForm;

	public function __construct(Login $loginForm)
	{
		$this->beforeFilter('guest', ['only' => ['create']]);
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->loginForm = $loginForm;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->loginForm->validate(Input::all());
		if(Auth::attempt(Input::only('email', 'password')))
		{
			return Redirect::intended('/');
		}

		$message = [
			'class' => 'danger',
			'message' => 'Invalid username or password.'
		];

		return Redirect::back()->withInput()->with('message', $message);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('login');
	}


}
