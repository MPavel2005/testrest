<?php

class Database {
    private static $host = 'mysql';
    private static $port = '3306';
    private static $user = 'root';
    private static $password = 'root';
    public static $dbname = 'test2';
    private static $connection = null;

    private function __construct() {

        try {
            self::$connection = new PDO(
                "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname,
                self::$user,
                self::$password
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //self::$connection->query($sql);

        } catch (PDOException $e) {
            die('Ошибка mysql: ' . $e->getMessage());
        }
    }

    public static function getConnection() {
        if (self::$connection == null) {
            new self();
        }
        return self::$connection;
    }

    public static function disconnect() {
        self::$connection = null;
    }
}