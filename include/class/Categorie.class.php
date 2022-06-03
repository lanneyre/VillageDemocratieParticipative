<?php
class Categorie extends Utils
{
    protected int $categorie_ID;
    protected string $categorie_nom;
    protected string $categorie_description;

    public function __construct(int $categorie_ID = 0, string $categorie_nom = "", string $categorie_description = "")
    {
        $this->categorie_ID = $categorie_ID;
        $this->categorie_nom = $categorie_nom;
        $this->categorie_description = $categorie_description;
    }

    public static function getById(int $categorie_ID): Categorie
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM categorie WHERE categorie_ID = :categorie_ID";
        $req = $con->prepare($sql);
        $req->execute([":categorie_ID" => $categorie_ID]);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Categorie");
        return $req->fetch();
    }

    private function existInDb(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM categorie WHERE categorie_ID = :categorie_ID";
        $req = $con->prepare($sql);
        $req->execute([":categorie_ID" => $this->categorie_ID]);
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
            $sql = "INSERT INTO `categorie` (`categorie_ID`, `categorie_nom`, `categorie_description`) VALUES (:categorie_ID, :categorie_nom, :categorie_description)";
        }
        $req = $con->prepare($sql);

        foreach ($this as $key => $value) {
            # code...
            if ($key == "categorie_ID" && $value == 0) {
                $req->bindValue($key, null);
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
            $sql = "DELETE FROM `categorie` WHERE `categorie_ID` = :categorie_ID";
            $query = $con->prepare($sql);
            $query->execute([":categorie_ID" => $this->categorie_ID]);
        }
    }
}
