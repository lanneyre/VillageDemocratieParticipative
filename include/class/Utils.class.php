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
    }
}
