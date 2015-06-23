<?php

use Protestr\Forms\CreateComment;
use Protestr\Forms\FormValidationException;

class CommentsController extends \BaseController {

	public function __construct(CreateComment $createCommentForm)
	{
		$this->beforeFilter('auth', ['except' => 'show', 'index']);
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->createCommentForm = $createCommentForm;
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
	public function create($protest_id)
	{
		if (!Session::get('protest')) return Redirect::route('home');
		$protest = Session::get('protest');
		return View::make('comments.create', compact('protest'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($protest_id)
	{
		$data = $this->createCommentForm->sanitize(Input::all());
		$protest = Protest::findOrFail($protest_id);

		try
		{
			$this->createCommentForm->validate($data);
		}
		catch (FormValidationException $e)
		{
			return Redirect::route('protest.comments.create', $protest->id)->withInput()->withErrors($e)->with(['protest'=>$protest]);
		}

		$comment = Comment::create([
			'user_id' => Auth::user()->id,
			'protest_id' => $protest->id,
			'parent' => $data['parent'],
			'body' => $data['comment']
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
	public function update($protest_id, $comment_id)
	{
		$comment = Comment::find($comment_id);
		$comment->toggleVote(Auth::user()->id);

		return Response::json([
			'newCount' => $comment->upvotes->count(),
			'status' => $comment->upvoted(Auth::user()->id) ? 'upvoted' : 'upvote'
		]);
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
