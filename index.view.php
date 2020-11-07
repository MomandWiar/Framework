<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <ul>
	    <?php
	        foreach($task as $t) {
	        	echo "<li>$t->name</li>";
	        }
	    ?>
    </ul>
</body>
</html>