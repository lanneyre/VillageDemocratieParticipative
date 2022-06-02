<?php
class Proposition extends Utils
{
    protected int $proposition_ID;
    protected string $proposition_etat;
    protected string $proposition_titre;
    protected string $proposition_description;
    protected string|DateTime $proposition_date;
    protected string|null $proposition_img;
    private string $villageois_EMAIL;
    private int $categorie_ID;
    private String $perioded;
    private String $periodef;

    function __construct(int $proposition_ID = 0, string $proposition_etat = "", string $proposition_titre = "", string $proposition_description = "", string $proposition_date = "", string $proposition_img = "", string $villageois_EMAIL = "", int $categorie_ID = 0, string $perioded = "", string $periodef = "")
    {
        $this->proposition_ID = $proposition_ID;
        $this->proposition_etat = $proposition_etat;
        $this->proposition_titre = $proposition_titre;
        $this->proposition_description = $proposition_description;
        $this->proposition_date = empty($proposition_date) ? new DateTime() : new DateTime($proposition_date);
        $this->proposition_img = $proposition_img;
        //var_dump($villageois);
        $this->villageois_EMAIL = $villageois_EMAIL;
        $this->categorie_ID = $categorie_ID;
        $this->perioded = $perioded;
        $this->periodef = $periodef;
        //$this->periode = empty($categorie) || empty($categorie) ? "" : Periode::getByDate(new DateTime($perioded), new DateTime($periodf));
    }

    public static function getById(int $proposition_ID): Proposition
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM proposition WHERE proposition_ID = :proposition_ID";
        $req = $con->prepare($sql);
        $req->execute([":proposition_ID" => $proposition_ID]);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Proposition");
        return $req->fetch();
    }
    public function villageois(): Villageois
    {
        return Villageois::getByEmail($this->villageois_EMAIL);
    }
    public function categorie(): Categorie
    {
        return Categorie::getById($this->categorie_ID);
    }
    public function periode(): Periode
    {
        return Periode::getByDate(new DateTime($this->perioded), new DateTime($this->periodef));
    }
}
