<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
</head>
<body>
	<h1>Home</h1>

	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/about">About</a></li>
		<li><a href="/contact">Contact</a></li>
	</ul>

    <ul>
	    <?php foreach($tasks as $task) : ?>
	        <li><?= $task->name; ?></li>
	    <?php endforeach; ?>
    </ul>

    <form method='POST' action="/add-name">
    	<input name='name'></input>
    	<button type='submit'>Submit</button>
    </form>
</body>
</html>