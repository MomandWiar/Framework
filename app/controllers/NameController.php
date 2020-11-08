<?php

namespace Wiar\Controllers;

use App\Core\App;

class NameController
{
    /**
    * Store a new user in the database.
    */
	public function addName()
	{
		App::get('database')->insert('posts', [
			'name' => $_POST['name']
		]);

		App::get('database')->selectAll('posts');

		return redirect('index');
	}
}