<?php
abstract class Utils
{
    public function __get($attribut)
    {
        if (isset($this->$attribut)) {
            return $this->$attribut;
        } else {
            return "la propriété n'existe pas !";
        }
    }

    public function __set($name, $value)
    {
        if ($this->$name instanceof DateTime) {
            $this->$name = new DateTime($value);
        } else if ($name != "villageois_EMAIL") {
            $this->$name = $value;
        }
        // $this->save();
    }

    public static function all()
    {
        $con = Bdd::getCon();
        $class = get_called_class();
        $sql = "SELECT * FROM " . strtolower($class);
        // $this->exist();
        $req = $con->query($sql);
        //var_dump($class);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
        //$req->setFetchMode(PDO::FETCH_OBJ);
        return $req->fetchAll();
    }
}
