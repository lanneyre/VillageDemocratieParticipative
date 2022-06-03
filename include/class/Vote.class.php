<?php
class Vote extends Utils
{
    private string $villageois_EMAIL;
    private int $proposition_ID;
    protected int $points_atribues;
    protected DateTime $vote_date;

    public function __construct(string $villageois_EMAIL = "", int $proposition_ID = 0, int $points_atribues = 0, string $vote_date = "")
    {
        $this->villageois_EMAIL = $villageois_EMAIL;
        $this->proposition_ID = $proposition_ID;
        $this->points_atribues = $points_atribues;
        $this->vote_date = empty($vote_date) ? new DateTime() : new DateTime($vote_date);
    }

    private function existInDb(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM vote WHERE villageois_EMAIL = :villageois_EMAIL AND proposition_ID = :proposition_ID";
        $req = $con->prepare($sql);
        $req->execute([":villageois_EMAIL" => $this->villageois_EMAIL, ":proposition_ID" => $this->proposition_ID]);
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
            $sql = "UPDATE `categorie` SET `categorie_nom` = :categorie_nom, `categorie_description` = :categorie_description WHERE `categorie`.`categorie_ID` = :categorie_ID";
        } else {
            $insert = true;
            $sql = "INSERT INTO `categorie` (`villageois_EMAIL`, `proposition_ID`, `points_atribues`, `vote_date`) VALUES (:villageois_EMAIL, :proposition_ID, :points_atribues, :vote_date)";
        }
        $req = $con->prepare($sql);

        foreach ($this as $key => $value) {
            # code...
            if ($value instanceof DateTime) {
                $req->bindValue($key, $value->format("Y-m-d"));
            } else {
                $req->bindValue($key, $value);
            }
        }
        $req->execute();
        if ($insert) {
            $this->categorie_ID = $con->lastInsertId();
        }
    }

    public function delete(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $sql = "DELETE FROM `categorie` WHERE villageois_EMAIL = :villageois_EMAIL AND proposition_ID = :proposition_ID";
            $query = $con->prepare($sql);
            $query->execute([":villageois_EMAIL" => $this->villageois_EMAIL, ":proposition_ID" => $this->proposition_ID]);
        }
    }

    public function villageois(): Villageois
    {
        return Villageois::getByEmail($this->villageois_EMAIL);
    }
    public function proposition(): Proposition
    {
        return Proposition::getById($this->proposition_ID);
    }
}
