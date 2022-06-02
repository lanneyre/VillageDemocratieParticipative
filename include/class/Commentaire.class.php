<?php
class Commentaire extends Utils
{
    protected int $commentaire_ID;
    protected string $commentaire_texte;
    protected DateTime $commentaire_date;
    protected string $commentaire_etat;
    private int $proposition_ID;
    private string $villageois_EMAIL;

    public function __construct(int $id = 0, string $texte = "", string $date = "", string $etat = "", int $proposition_ID = 0, string $villageois_EMAIL = "")
    {
        $this->commentaire_ID = $id;
        $this->commentaire_texte = $texte;
        $this->commentaire_date = empty($date) ? new DateTime() : new DateTime($date);
        $this->commentaire_etat = $etat;
        $this->proposition_ID = $proposition_ID;
        $this->villageois_EMAIL = $villageois_EMAIL;
    }

    public function proposition(): Proposition
    {
        return Proposition::getById($this->proposition_ID);
    }

    public function villageois(): Villageois
    {
        return Villageois::getByEmail($this->villageois_EMAIL);
    }
}
