<?php
require('view_begin.php');
?>

<form class="form-inline" action = "?controller=home&action=recherche" method="post" >
				<input type="text" name="name" size="50" placeholder="Mot clés"/>
				<input type="submit" value="Chercher" class="btn btn-primary mb-2"/></form>

<ul>			
<?php foreach ($liste as $key => $value):  ?>
				<li>Mot trouvé dans le document : <a href="Content/doc/<?=$value["Document"]?>"><?=$value["Document"]?></a>. Avec <?=$value["Occurence"]?> occurence</li>
<?php endforeach ?>
</ul>	
<?php
require('view_end.php');
?>
