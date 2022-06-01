<?php
class Periode extends Utils
{
    protected DateTime $periode_date_debut;
    protected DateTime $periode_date_fin;
    protected string $type_periode;

    public function __construct(string $debut = "", string $fin = "", string $type_periode = "")
    {
        $this->periode_date_debut = empty($debut) ? new DateTime() : new DateTime($debut);
        $this->periode_date_fin = empty($fin) ? new DateTime() : new DateTime($fin);
        $this->type_periode = $type_periode;
    }
}
