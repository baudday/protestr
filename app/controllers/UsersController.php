<?php

use Protestr\Forms\SignUp;
use Protestr\Forms\FormValidationException;

class UsersController extends \BaseController {

	protected $signUpForm;


	function __construct(SignUp $signUpForm)
	{
		$this->beforeFilter('guest', ['only' => ['create']]);
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->signUpForm = $signUpForm;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->signUpForm->validate(Input::all());
		User::create(Input::only('email','username','password'));
		$message = [
			'class' => 'success',
			'message' => 'Registration successful! You can now login.'
		];
		return Redirect::route('login')->withInput()->with('message', $message);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $username
	 * @return Response
	 */
	public function show($username)
	{
		$user = User::where('username', $username)->firstOrFail();
		return View::make('users.show', compact('user'));
	}

}
