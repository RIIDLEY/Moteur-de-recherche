<?php

class Controller_home extends Controller{

  public function action_home(){
    $m = Model::getModel();
    
    $this->indexation("poeme.txt");   
    /*$listemotvide = file_get_contents ("Utils/Liste_Mot_Vide.txt");
    $separateurs2 =  "\n" ;//faut retirer l'espace !!
    $motvide = explode($separateurs2,$listemotvide);
    $keywords = explode(" ",$motvide[0]);*/
    //print_r($motvide);

    /*for ($i=0; $i < count($motvide); $i++) { 
      if ("ainsi"===trim($motvide[$i])) {
        echo "couucou";
      }
    }*/

    
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

    if ($files){
      $filecount = count($files);
    } 

    if($nbdoc == 0 And $filecount >= 1){
      $name = explode("/", $files[0]);
      $m->addDoc($name[2]);
    }   

      for ($i=0; $i < $filecount; $i++) { 
        $statue = true;
        $name = explode("/", $files[$i]);
        $getDocDB = $m->getDocument();
        foreach ($getDocDB as $key =>$value) {
          if ($value == $name[2]) {
            $statue = false;
          }
        }

        if($statue == true){
          $m->addDoc($name[2]);
          $this->indexation($name[2]);         
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


  
}

?>
