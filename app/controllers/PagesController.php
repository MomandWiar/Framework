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
        App::get('database')->select('tasks');

        $tasks = App::get('database')->fetchAll();

		return view('index', compact('tasks'));
	}

    /**
     * Show the about page.
     */
	public function getAbout()
	{
        App::get('database')->update('tasks',['name' => 'Peter'],['id' => 35]);

		return view('about');
	}

    /**
     * Show the about culture page.
     */
    public function getAboutCulture()
    {
        App::get('database')->delete('tasks',['id' => 36]);

        return view('about-culture');
    }

    /**
     * Show the contact page.
     */
	public function getContact()
	{
		return view('contact');
	}
}