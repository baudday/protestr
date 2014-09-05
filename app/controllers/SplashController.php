<?php

use Protestr\Forms\Splash;

class SplashController extends \BaseController {

	protected $splashForm;

	public function __construct(Splash $splashForm)
	{
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->splashForm = $splashForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pages.splash');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = $this->splashForm->sanitize(Input::all());
		$this->splashForm->validate($data);

		$mcUrl = 'http://protestr.us9.list-manage1.com/subscribe/post';
		$mcData = [
			'MERGE0' => $data['email'],
			'u'      => $data['u'],
			'id'     => $data['id'],
		];

		//url-ify the data for the POST
		$fields_string = '';
		foreach($mcData as $key=>$value) {
			$fields_string .= $key.'='.$value.'&';
		}
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $mcUrl);
		curl_setopt($ch,CURLOPT_POST, count($mcData));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}

	public function thanks()
	{
		$message = [
			'class' => 'success',
			'message' => '<strong>Almost finished!</strong> To confirm your subscription, please click the link in the email we just sent you.'
		];
		return View::make('pages.splash', compact('message'));
	}

}