<?php

class Controller_home extends Controller{

  public function action_home(){
    $m = Model::getModel();
    
    $this->gestionfichier();
    $tabsend = array();

    $this->render('home',['liste'=>$tabsend]);
}

  public function action_default(){//fonction appele par defaut par la page
    $this->action_home();
  }

  public function gestionfichier(){
    $m = Model::getModel();//recupere le model
    $nbdoc = $m->getNbDoc();//retourne le nombre de document present sur la BDD
    $directory = "Content/doc/";
    $filecount = 0;
    $files = glob($directory . "*");
    $getDocDB = $m->getDocument();//retourne liste des documents reference dans la BDD

    if ($files){//calcule le nombre de fichier sur le serveur
      $filecount = count($files);
    } 

    //nettoyage de la BDD, supprime dans la BDD les données qui ne sont plus présent dans le serveur. Si un fichier a été supprimé sur le serveur, la BDD le supprime de ses données
    foreach ($getDocDB as $key =>$value) {// boule qui sort les elements dans la BDD
      $trouve = false;
      for ($i=0; $i < $filecount; $i++) { // boule qui sort les elements dans le serveur
        $name = explode("/", $files[$i]);
        if ($value == $name[2]) {//s'il le trouve danbs la BDD
          $trouve = true;// on modifie le statue de la var
        }
      }
      if ($trouve == false) {//s'il ne trouve pas
        $m->removeDoc($value);//supprime de la table document
        $m->removeMot($value);//supprime de la table listemot
      }
    }

    //ajout dans la BDD des nouuveaux fichiers trouvé
    for ($i=0; $i < $filecount; $i++) {// boule qui sort les elements dans le serveur
      $trouve2 = false;
      $DocServ = explode("/", $files[$i]); //explode pour sortir uniquement le nom du fichier avec son type. Si pas d'explode cela sort tout le chemin
      foreach ($getDocDB as $key => $value) {// boule qui sort les elements dans la BDD
        if($DocServ[2]==$value){//s'il est deja dans la BDD
          $trouve2 = true;// change le statue de la var
        }
      }
      if ($trouve2 == false) {//s'il n'est pas dans la BDD
        $m->addDoc($DocServ[2]);//ajoute dans la table document pour le referencer
        $this->indexation($DocServ[2]);//fait l'indexation
      }
    }

  }

  public function explode_bis($texte, $separateurs){
	  $tok =  strtok($texte, $separateurs);//separe la chaine en tableau par rapport aux separateurs
    $listemotvide = file_get_contents ("Utils/Liste_Mot_Vide.txt");//Sort le fichier de mot vide
    $separateurs2 =  "\n" ;
    $motvide = explode($separateurs2,$listemotvide);//met le fichier de mot vide sous forme de tableau
    $tab_tok=array();

    for ($i=0; $i < count($motvide); $i++) {//enleve les espaces present au tour des mots du fichier de mot vide
      $motvide[$i] = trim($motvide[$i]);
    }

	  if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;//Si la taille du mot est supérieur à 2 et qu'il est pas present dans le tableau de mot vide on le garde

	    while ($tok !== false) {
		      $tok = strtok($separateurs);
		      if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;//Si la taille du mot est supérieur à 2 et qu'il est pas present dans le tableau de mot vide on le garde
	    }

	return $tab_tok;
  }

  public function indexation($document){
    $m = Model::getModel();
    $chemin = "Content/doc/" . $document;//generation du chemin
    $texte = file_get_contents ($chemin);//lecture du fichier
    $separateurs =  "’'. ,…][(«»)/\r\n|\n|\r/" ;//caracteres de séparation des mots
	  $tab_toks = $this->explode_bis(mb_strtolower($texte,'UTF-8'), $separateurs);//séparation

    $tab_new_mots_occurrences = array_count_values ($tab_toks);//compte le nombre d'occurence

    foreach($tab_new_mots_occurrences as $k=> $v){//Boucle qui tourne dans le tableau $tab_new_mots_occurrences qui contient le mot avec son occurence et le document dont il provient
      $infos = array("Mot"=>$k,"Occurence"=>$v,"Document"=>$document);
      $m->addMot($infos);//ajoute dans la BDD
    }

  }

  public function action_recherche(){//cherche un mot clé
    $m = Model::getModel();
    $this->gestionfichier();//verification des fichiers
    $tabsend = array();
  if(isset($_POST['name']) and !preg_match("#^\s*$#",$_POST['name'])){
    $str = mb_strtolower($_POST['name'], 'UTF-8');
    $tab = $m->getMot($str);//vas chercher s'il existe dans la BDDD
    if (empty($tab)) {//si il n'y a rien
      echo "<script>alert(\"Rien trouvé\")</script>";//alert pop up
    }else {//s'il y a quelque chose
      foreach ($tab as $key => $value) {//fait un tableau de tableau avec les informations
        $tabsend[] = array("Nom"=>$value[1],"Occurence"=>$value[2],"Document"=>$value[3]);
      }
    }
  }

  $this->render('home', ['liste'=>$tabsend]);//envoie les données à la page
}

  
}

?>
