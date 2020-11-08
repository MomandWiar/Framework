<?php require 'partials/head.php' ?>

<h1>Home</h1>

<ul>
    <?php foreach($tasks as $task) : ?>
        <li><?= $task->name; ?></li>
    <?php endforeach; ?>
</ul>


<form method='POST' action="/add-name">
	<input name='name'></input>
	<button type='submit'>Submit</button>
</form>

<br>

<?php require 'partials/footer.php' ?>