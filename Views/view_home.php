<?php
require('view_begin.php');
?>

<form action = "?controller=home&action=recherche" method="post">
				<p> <input type="text" name="name"/></p>
				<p>  <input type="submit" value="Chercher"/> </p>

<ul>			
<?php foreach ($liste as $key => $value):  ?>
				<li>Mot trouvé dans le document : <a href="Content/doc/<?=$value["Document"]?>"><?=$value["Document"]?></a>. Avec <?=$value["Occurence"]?> occurence</li>
<?php endforeach ?>
</ul>	
<?php
require('view_end.php');
?>
