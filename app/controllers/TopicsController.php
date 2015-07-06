<?php

class TopicsController extends \BaseController {

    public function show($slug)
    {
        $page_topic = \Topic::where('slug', $slug)->firstOrFail();
        $topics = \Topic::all();

        return View::make('protests.index', compact('topics', 'page_topic', 'slug'));
    }

}
