<?php
include_once("include/Autoloader.inc.php");
Autoloader::register();

// $cat = new Categorie(5, "demo", "insulte");
// // $cat->setNom("salut les PHP");
// // var_dump($cat);
// echo $cat->categorie_ID . "\n";
// echo $cat->categorie_IDe . "\n";
// echo $cat->categorie_nom . "\n";
// $cat->categorie_nom = "Utilisation du setter magique";
// echo $cat->categorie_nom . "\n";

// $cat->ditCoucou();

// $villageois1 = new Villageois();
// $villageois1->villageois_EMAIL = "pierreAntoine@besoindidees.meilleures";
// $villageois1->villageois_nom = "Pierre Antoine";

// $villageois2 = new Villageois();
// $villageois2->villageois_EMAIL = "pierreAntoine@free.fr";
// $villageois2->villageois_nom = "PierreAntoine Truc";

// $cat = new Categorie(5, "demo", "insulte");
// $periode = new Periode("2022-05-01", "2022-05-22", "proposition");

// $proposition = new Proposition(1, "etat_enattente", "une super proposition de titre : AC2V", "un titre en debat", "2022-05-17", "quelquepart.jpg", $villageois2, $cat, $periode);

// echo $proposition->villageois->villageois_nom . "\n";
// echo $villageois2->villageois_EMAIL;



echo "<pre>";


// avec Static
//$testv = Villageois::getByEmail(email: "pierreAntoine@free.fr");
//var_dump($testv);

// Sans Static (presque)
//$testV = new Villageois("pierreAntoine@free.fr");
//var_dump($testV);
//$testV->recupDataInTheBdd();
//var_dump($testV);

// $testProp = Proposition::getById(1);
// var_dump($testProp->periode());
// var_dump(Villageois::all());
// $newCat = new Categorie(categorie_nom: "PHP5", categorie_description: "l'a qraime dé phranssé");
// $newCat->save();
// echo "<hr>";
// $recupVil = Villageois::getByEmail("22 rue des idéalistes");

// $recupCat->categorie_description = "La crème de la France";
// var_dump($recupVil);
// $recupCat->save();
// $recupVil->delete();

// echo "<hr>";
// var_dump(Villageois::all());

// echo "<hr>";
// var_dump(Categorie::all());
var_dump(Commentaire::all());
// $com = new Commentaire(texte: "les PHP5 sont fatigués", date: (new DateTime())->format("Y-m-d"), etat: "actif", proposition_ID: 1, villageois_EMAIL: "pierreAntoine@free.fr");
$com = Commentaire::getById(1);
$com->commentaire_texte = "Les PHP sont en pause";
$com->save();
echo "<hr>";
var_dump(Commentaire::all());
echo "</pre>";
// $testv->villageois_adresse = "22 rue des idéalistes";
// $testv->villageois_EMAIL = "22 rue des idéalistes";
// $testv->save();

// $testInsert = new Villageois("test2@test2.com3", "test 42 ", "23", "f,dvbjvkd", "1986-09-02", "oui");
// $testInsert->save();
// //var_dump($testV);

Bdd::close();
