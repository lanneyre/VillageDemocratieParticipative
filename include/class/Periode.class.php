<?php
class Periode extends Utils
{
    protected string|DateTime $periode_date_debut;
    protected string|DateTime $periode_date_fin;
    protected string $type_periode;

    public function __construct(string $periode_date_debut = "", string $periode_date_fin = "", string $type_periode = "")
    {
        $this->periode_date_debut = empty($periode_date_debut) ? new DateTime() : new DateTime($periode_date_debut);
        $this->periode_date_fin = empty($periode_date_fin) ? new DateTime() : new DateTime($periode_date_fin);
        $this->type_periode = $type_periode;
    }

    public static function getByDate(DateTime $dd, DateTime $df): Periode
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM periode WHERE periode_date_debut = :periode_date_debut AND periode_date_fin = :periode_date_fin";
        $req = $con->prepare($sql);
        $req->execute([":periode_date_debut" => $dd->format("Y-m-d"), ":periode_date_fin" => $df->format("Y-m-d")]);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Periode");
        return $req->fetch();
    }

    private function existInDb(): bool
    {
        $con = Bdd::getCon();
        $sql = "SELECT * FROM periode WHERE periode_date_debut = :periode_date_debut AND periode_date_fin = :periode_date_fin";
        $req = $con->prepare($sql);
        if ($this->periode_date_debut instanceof DateTime && $this->periode_date_fin instanceof DateTime) {
            $dd = $this->periode_date_debut->format("Y-m-d");
            $df = $this->periode_date_fin->format("Y-m-d");
        } else {
            $dd = $this->periode_date_debut;
            $df = $this->periode_date_fin;
        }
        $req->execute([":periode_date_debut" => $dd, ":periode_date_fin" => $df]);
        if ($req->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function save(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $sql = "UPDATE `periode` SET `type_periode` = :type_periode WHERE `periode`.`periode_date_debut` = :periode_date_debut AND `periode`.`periode_date_fin` = :periode_date_fin";
        } else {
            $sql = "INSERT INTO `periode` (`periode_date_debut`, `periode_date_fin`, `type_periode`) VALUES (:periode_date_debut, :periode_date_fin, :type_periode)";
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
        //$req->debugDumpParams();
    }

    public function delete(): void
    {
        $con = Bdd::getCon();
        if ($this->existInDb()) {
            $sql = "DELETE FROM `periode` WHERE periode_date_debut = :periode_date_debut AND periode_date_fin = :periode_date_fin";
            $query = $con->prepare($sql);
            $query->execute([":periode_date_debut" => $this->periode_date_debut, ":periode_date_fin" => $this->periode_date_fin]);
        }
    }
}
