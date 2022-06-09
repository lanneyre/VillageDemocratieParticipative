<?php

include_once("../include/Autoloader.inc.php");
Autoloader::register();

// gestion de l'url 
//$v = new View();
// $page = "../include/view/" . strtolower($_GET['page']) . "view.php";
// if (file_exists($page)) {
//     $vue = file_get_contents($page);
// } else {
//     $vue = file_get_contents("../include/view/accueil.view.php");
// }



// $view = str_replace("[[main]]", $vue, $template);

echo new Page(title: "Accueil", page: strtolower($_GET['page']));
