<?php
require('view_begin.php');
?>

<form action = "?controller=home&action=recherche" method="post">
				<p> <input type="text" name="name"/></p>
				<p>  <input type="submit" value="Chercher"/> </p>
<?php
require('view_end.php');
?>
