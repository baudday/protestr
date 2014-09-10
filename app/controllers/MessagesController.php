<?php

use Protestr\Forms\CreateMessage;
use Protestr\Forms\FormValidationException;

class MessagesController extends \BaseController {

	protected $createMessageForm;

	function __construct(CreateMessage $createMessageForm)
	{
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->createMessageForm = $createMessageForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Inbox
		$messages = Message::with('sender')
			->threads()
			->receivedBy(Auth::user()->id)
			->get();

		return View::make('messages.index', compact('messages'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (!Session::get('user')) return Redirect::route('home');
		$user = Session::get('user');
		return View::make('messages.create', compact('user'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = $this->createMessageForm->sanitize(Input::all());
		$to = User::findOrFail($data['to_id']);

		// Gotta handle this exception here, cause we want different
		// behavior from what's in global.php
		try
		{
			$this->createMessageForm->validate($data);
		}
		catch (FormValidationException $e)
		{
			return Redirect::route('messages.create')->withInput()->withErrors($e)->with(['user'=>$to]);
		}

		if ($data['to_username'] !== $to->username)
		{
			$message = [
				'class' => 'danger',
				'message' => '<strong>Oops!</strong> Something went wrong. Please try again.'
			];

			return Redirect::route('users.show', ['username' => $to->username])->with(compact('message'));
		}

		$message = Message::create([
			'sender_id' => Auth::user()->id,
			'receiver_id' => $data['to_id'],
			'message' => $data['message']
		]);
		return Redirect::route('messages.show', ['username' => $data['to_username']]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($username)
	{
		// Individual thread
		$user = User::whereUsername($username)->firstOrFail();
		$messages = Message::with('sender')
								->thread(Auth::user()->id, $user->id)->get();

		// Mark messages as read
		$unread = $messages->filter(function($message)
		{
			return !$message->read && $message->sender_id !== Auth::user()->id;
		});

		$unread->each(function($message)
		{
			$message->read = true;
			$message->save();
		});

		return View::make('messages.show', compact('user', 'messages'));
	}


}
