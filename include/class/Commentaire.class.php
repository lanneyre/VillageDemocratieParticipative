<?php
class Commentaire extends Utils
{
    protected int $commentaire_ID;
    protected string $commentaire_texte;
    protected DateTime $commentaire_date;
    protected string $commentaire_etat;
    protected Proposition $proposition;
    protected Villageois $villageois;

    public function __construct(int $id = 0, string $texte = "", string $date = "", string $etat = "", Proposition $proposition = null, Villageois $villageois = null)
    {
        $this->commentaire_ID = $id;
        $this->commentaire_texte = $texte;
        $this->commentaire_date = empty($date) ? new DateTime() : new DateTime($date);
        $this->commentaire_etat = $etat;
        $this->proposition = $proposition;
        $this->villageois = $$villageois;
    }
}
