<?php
class Categorie extends Utils
{
    private int $categorie_ID;
    private string $categorie_nom;
    private string $categorie_description;

    public function __construct(string $id = null, string $nom = "", string $description = "")
    {
        $this->categorie_ID = $id;
        $this->categorie_nom = $nom;
        $this->categorie_description = $description;
    }
}
