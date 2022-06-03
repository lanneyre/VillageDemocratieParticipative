<?php
class Commentaire extends Utils
{
    protected int $commentaire_ID;
    protected string $commentaire_texte;
    protected string|DateTime $commentaire_date;
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

    public static function getById(int $commentaire_ID): Commentaire
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM commentaire WHERE commentaire_ID = :commentaire_ID";
        $req = $con->prepare($sql);
        $req->execute([":commentaire_ID" => $commentaire_ID]);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Commentaire");
        return $req->fetch();
    }

    private function existInDb(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM commentaire WHERE commentaire_ID = :commentaire_ID";
        $req = $con->prepare($sql);
        $req->execute([":commentaire_ID" => $this->commentaire_ID]);
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
            $sql = "UPDATE `commentaire` SET `commentaire_texte` = :commentaire_texte, `commentaire_date` = :commentaire_date, `commentaire_etat` = :commentaire_etat, `proposition_ID` = :proposition_ID, `villageois_EMAIL` = :villageois_EMAIL WHERE `commentaire`.`commentaire_ID` = :commentaire_ID ";
        } else {
            $insert = true;
            $sql = "INSERT INTO `commentaire` (`commentaire_ID`, `commentaire_texte`, `commentaire_date`, `commentaire_etat`, `proposition_ID`, `villageois_EMAIL`) VALUES (:commentaire_ID, :commentaire_texte, :commentaire_date, :commentaire_etat, :proposition_ID, :villageois_EMAIL) ";
        }
        $req = $con->prepare($sql);

        foreach ($this as $key => $value) {
            # code...
            if ($key == "commentaire_ID" && $value == 0) {
                $req->bindValue($key, null);
            } else if ($key == "commentaire_date") {
                $req->bindValue($key, (new DateTime())->format("Y-m-d H:i:s"));
            } else {
                $req->bindValue($key, $value);
            }
        }
        $req->execute();
        if ($insert) {
            $this->commentaire_ID = $con->lastInsertId();
        }
        //$req->debugDumpParams();
    }

    public function delete(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $sql = "DELETE FROM `commentaire` WHERE `commentaire_ID` = :commentaire_ID";
            $query = $con->prepare($sql);
            $query->execute([":commentaire_ID" => $this->commentaire_ID]);
        }
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
