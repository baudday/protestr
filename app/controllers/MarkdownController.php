<?php

use League\CommonMark\CommonMarkConverter;

class MarkdownController extends \BaseController {

	/**
	 * Return parsed markdown
	 *
	 * @return Response
	 */
	public function preview()
	{
		$body = Input::get('body');

		$converter = new CommonMarkConverter();
    $parsed = $converter->convertToHtml($body);

    return Response::json(['body' => $parsed]);
	}


}
