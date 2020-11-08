<?php

namespace Wiar\Controllers;

use Wiar\Core\App;

class PagesController
{
    /**
    * Show the home page.
    */
	public function getHome()
	{
		$tasks = App::get('database')->selectAll('tasks');

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