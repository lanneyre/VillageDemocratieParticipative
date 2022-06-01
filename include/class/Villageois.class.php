<?php
class Villageois extends Utils
{
    protected string $villageois_EMAIL;
    protected string $villageois_nom;
    protected string $villageois_prenom;
    protected string $villageois_adresse;
    protected DateTime $villageois_date_naissance;
    protected string $villageois_mot_de_passe;
    protected string $villageois_privilege;
    protected string $villageois_mandat;

    function __construct(string $email = "", string $nom = "", string $prenom = "", string $adresse = "", string $dob = "", string $mdp = "", string $privilege = "privilege_user", string $mandat = "mandat_habitant")
    {
        $this->villageois_EMAIL = $email;
        $this->villageois_nom = $nom;
        $this->villageois_prenom = $prenom;
        $this->villageois_adresse = $adresse;
        $this->villageois_date_naissance = empty($dob) ? new DateTime() : new DateTime($dob);
        $this->villageois_mot_de_passe = password_hash($mdp, PASSWORD_DEFAULT);
        $this->villageois_privilege = $privilege;
        $this->villageois_mandat = $mandat;
    }

    public static function all()
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM villageois";
        // $this->exist();
        $req = $con->query($sql);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Villageois");
        return $req->fetchAll();
    }

    public static function getByEmail(string $email): Villageois
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM villageois WHERE villageois_EMAIL = :villageois_EMAIL";
        $req = $con->prepare($sql);
        $req->execute([":villageois_EMAIL" => $email]);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Villageois");
        return $req->fetch();
    }

    public function recupDataInTheBdd(): void
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM villageois WHERE villageois_EMAIL = :villageois_EMAIL";
        $req = $con->prepare($sql);
        $req->execute([":villageois_EMAIL" => $this->villageois_EMAIL]);
        $v = $req->fetch(PDO::FETCH_OBJ);
        foreach ($v as $cle => $value) {
            if ($this->$cle instanceof DateTime) {
                $this->$cle = new DateTime($value);
            } else {
                $this->$cle = $value;
            }
        }
    }

    private function exist(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM villageois WHERE villageois_EMAIL = :villageois_EMAIL";
        $req = $con->prepare($sql);
        $req->execute([":villageois_EMAIL" => $this->villageois_EMAIL]);
        if ($req->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function save(): void
    {
        $con = Bdd::getCon();
        if ($this->exist()) {
            $sql = "UPDATE `villageois` SET `villageois_nom` = :villageois_nom, `villageois_prenom` = :villageois_prenom, `villageois_adresse` = :villageois_adresse, `villageois_date_naissance` = :villageois_date_naissance, `villageois_mot_de_passe` = :villageois_mot_de_passe, `villageois_privilege` = :villageois_privilege, `villageois_mandat` = :villageois_mandat WHERE `villageois`.`villageois_EMAIL` = :villageois_EMAIL";
        } else {
            $sql = "INSERT INTO `villageois` (`villageois_EMAIL`, `villageois_nom`, `villageois_prenom`, `villageois_adresse`, `villageois_date_naissance`, `villageois_mot_de_passe`, `villageois_privilege`, `villageois_mandat`) VALUES (:villageois_EMAIL, :villageois_nom, :villageois_prenom, :villageois_adresse, :villageois_date_naissance, :villageois_mot_de_passe, :villageois_privilege, :villageois_mandat);";
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
    }
}
