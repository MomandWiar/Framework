<?php

namespace Wiar\Controllers;

use App\Core\App;

class PagesController
{
    /**
     * Show the home page.
     */
	public function getHome()
	{
		$task = App::get('database')->selectAll('posts');

		return view('index', compact('tasks'));
	}

    /**
     * Show the about page.
     */
	public function getAbout()
	{
		return view('about');
	}

    /**
     * Show the contact page.
     */
	public function getContact()
	{
		return view('contact');
	}
}