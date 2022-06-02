<?php
class Categorie extends Utils
{
    private int $categorie_ID;
    private string $categorie_nom;
    private string $categorie_description;

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
}
