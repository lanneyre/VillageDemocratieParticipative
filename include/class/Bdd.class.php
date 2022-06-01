<?php
class Bdd
{
    private static $user = "admin";
    private static $pass = "Y@tta!6623";
    private static $driver = "mysql";
    private static $charset = "utf8";
    private static $host = "localhost";
    private static $dbname = "projet_village_remplis";
    private static $con;

    public static function getCon()
    {
        if (empty(self::$con)) {
            self::$con = new PDO(self::$driver . ":host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset, self::$user, self::$pass);
        }
        return self::$con;
    }

    public static function close()
    {
        // self::$con->close();
        self::$con = null;
    }
}
