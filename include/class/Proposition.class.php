<?php
class Proposition extends Utils
{
    protected int $proposition_ID;
    protected string $proposition_etat;
    protected string $proposition_titre;
    protected string $proposition_description;
    protected DateTime $proposition_date;
    protected string $proposition_img;
    protected Villageois $villageois;
    protected Categorie $categorie;
    protected Periode $periode;

    function __construct(int $id = 0, string $etat = "", string $titre = "", string $description = "", string $date = "", string $img = "", Villageois $villageois = null, Categorie $categorie = null, Periode $periode = null)
    {
        $this->proposition_ID = $id;
        $this->proposition_etat = $etat;
        $this->proposition_titre = $titre;
        $this->proposition_description = $description;
        $this->proposition_date = empty($date) ? new DateTime() : new DateTime($date);
        $this->proposition_img = $img;
        $this->villageois = $villageois;
        $this->categorie = $categorie;
        $this->periode = $periode;
    }
}
