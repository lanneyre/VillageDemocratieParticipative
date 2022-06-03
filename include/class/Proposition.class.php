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

    private function existInDb(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM Proposition WHERE proposition_ID = :proposition_ID";
        $req = $con->prepare($sql);
        $req->execute([":proposition_ID" => $this->proposition_ID]);
        if ($req->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function save(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $insert = false;
            $sql = "UPDATE `proposition` SET `proposition_etat` = :proposition_etat, `proposition_titre` = :proposition_titre, `proposition_description` = :proposition_description, `proposition_date` = :proposition_date, `proposition_img` = :proposition_img, `villageois_EMAIL` = :villageois_EMAIL, `categorie_ID` = :categorie_ID WHERE `proposition`.`proposition_ID` = :proposition_ID ";
        } else {
            $insert = true;
            $sql = "INSERT INTO `proposition` (`proposition_ID`, `proposition_etat`, `proposition_titre`, `proposition_description`, `proposition_date`, `proposition_img`, `villageois_EMAIL`, `categorie_ID`, `perioded`, `periodef`) VALUES (:proposition_ID, :proposition_etat, :proposition_titre, :proposition_description, :proposition_date, :proposition_img, :villageois_EMAIL, :categorie_ID, :perioded, :periodef)";
        }
        $req = $con->prepare($sql);

        foreach ($this as $key => $value) {
            # code...
            if ($key == "proposition_ID" && $value == 0) {
                $req->bindValue($key, null);
            } else if ($key == "proposition_date") {
                $req->bindValue($key, (new DateTime())->format("Y-m-d H:i:s"));
            } else {
                $req->bindValue($key, $value);
            }
        }
        $req->execute();
        //$req->debugDumpParams();
        if ($insert) {
            $this->proposition_ID = $con->lastInsertId();
        }
    }

    public function delete(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $sql = "DELETE FROM `proposition` WHERE `proposition_ID` = :proposition_ID";
            $query = $con->prepare($sql);
            $query->execute([":proposition_ID" => $this->proposition_ID]);
        }
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
