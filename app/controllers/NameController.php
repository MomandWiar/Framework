<?php

namespace Wiar\Controllers;

use Wiar\Core\App;

class NameController
{
    /**
     * Store a new user in the database.
     */
	public function addName()
	{
		App::get('database')->insert('tasks', [
			'name' => $_POST['name']
		]);

		$test = 'hai';

		return redirect('', compact('test'));
	}
}