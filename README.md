# Moteur de recherche de Lahoucine HAMSEK
***

L'objectif de ce projet est de réaliser un moteur de recherche simple.
Ce moteur de recherche permet d'effectuer une analyse sur des documents texte.
Avant d'être analysé, ces documents sont indexés dans une base de données que le moteur de recherche utilise.
L'indexation s'effectue avec filtre de liste de mot vide.

## Technologies utilisés

Utilisation d'un design pattern MVC avec le langage PHP.  
Une Base de Données sous MySQL est utilisé pour stocker les données.  
J'ai utilisé WAMP pour travailler sur ce projet.  

## Comment l'installer

Il faut créer un nouvelle utilisateur MySQL/MariaDB avec comme login : "moteur-recherche" et comme mot de passe : "V1MCn2wMP8GFIefQ"  
Par la suite lancez le script SQL moteur-recherche.sql qui se trouve dans le dossier Utils.  
Il permet de créer la base de données ainsi que les tables nécessaires pour le moteur de recherche.  
Ensuite vous pouvez mettre le dossier contenant le site dans votre dossier qui permet de le lancer avec Apache.  
Allez sur votre navigateur Web, puis à l'adresse localhost/Moteur-de-recherche pour avoir accès au moteur de recherche.  
Les documents .txt qui sont traités sont dans le dossier Content/doc.

## Identifiant/mot de passe

Pour la base de données
* Login : moteur-recherche
* Mot de passe : V1MCn2wMP8GFIefQ
