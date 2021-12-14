<?php

class Controller_home extends Controller{

  public function action_home(){
    $m = Model::getModel();
    
    $this->gestionfichier();

    $this->render('home');
}

  public function action_default(){
    $this->action_home();
  }

  public function gestionfichier(){
    $m = Model::getModel();
    $nbdoc = $m->getNbDoc();
    $directory = "Content/doc/";
    $filecount = 0;
    $files = glob($directory . "*");
    $getDocDB = $m->getDocument();

    if ($files){
      $filecount = count($files);
    } 

    foreach ($getDocDB as $key =>$value) {//nettoyage de la DB, supprime dans la DB les données qui ne sont plus présent dans le serveur
      $trouve = false;
      for ($i=0; $i < $filecount; $i++) { 
        $name = explode("/", $files[$i]);
        if ($value == $name[2]) {
          $trouve = true;
        }
      }
      if ($trouve == false) {
        $m->removeDoc($value);
        $m->removeMot($value);
      }
    }

    for ($i=0; $i < $filecount; $i++) {//ajoutu dans la DB des nouuveaux fichiers non traité
      $trouve2 = false;
      $DocServ = explode("/", $files[$i]); 
      foreach ($getDocDB as $key => $value) {
        if($DocServ[2]==$value){
          $trouve2 = true;
        }
      }
      if ($trouve2 == false) {
        $m->addDoc($DocServ[2]);
        $this->indexation($DocServ[2]);  
      }
    }

  }

  public function explode_bis($texte, $separateurs){
	  $tok =  strtok($texte, $separateurs);//separe la chaine en tableau par rapport aux separateurs
    $listemotvide = file_get_contents ("Utils/Liste_Mot_Vide.txt");
    $separateurs2 =  "\n" ;
    $motvide = explode($separateurs2,$listemotvide);
    $tab_tok=array();

    for ($i=0; $i < count($motvide); $i++) { 
      $motvide[$i] = trim($motvide[$i]);
    }

	  if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;//si mot superieur à 2 char, on le garde

	    while ($tok !== false) {
		      $tok = strtok($separateurs);
		      if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;
	    }

	return $tab_tok;
  }

  public function indexation($document){
    $m = Model::getModel();
    $chemin = "Content/doc/" . $document;//generation du chemin
    $texte = file_get_contents ($chemin);//lecture du fichier
    $separateurs =  "’'. ,…][(«»)/\r\n|\n|\r/" ;//caracteres de séparation des mots
	  $tab_toks = $this->explode_bis(mb_strtolower($texte,'UTF-8'), $separateurs);//séparation

    $tab_new_mots_occurrences = array_count_values ($tab_toks);

    foreach($tab_new_mots_occurrences as $k=> $v){
      $infos = array("Mot"=>$k,"Occurence"=>$v,"Document"=>$document);
      $m->addMot($infos);
      
    }

  }

  public function action_recherche(){
    $m = Model::getModel();
    $tabsend = array();
  if(isset($_POST['name']) and !preg_match("#^\s*$#",$_POST['name'])){
    $tab = $m->getMot($_POST['name']);
    if (empty($tab)) {
      print("Rien trouvé");
    }else {
      foreach ($tab as $key => $value) {
        $tabsend[] = array("Nom"=>$value[1],"Occurence"=>$value[2],"Document"=>$value[3]);
      }
    }
  }

  $this->render('home', ['liste'=>$tabsend]);
}

  
}

?>
