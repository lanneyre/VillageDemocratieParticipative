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
}
