<?php

namespace App\Db;

use PDO;

/**
 * Class DbConn
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Db
 */
class Database implements DbConfig
{
    protected static $instance;

    protected function __construct()
    {
        throw new Exception("Can't __construct a singleton");
    }

    private function __clone()
    {
        throw new Exception("Can't __clone a singleton");
    }

    private function __wakeup()
    {
        throw new Exception("Can't __wakeup a singleton");
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            $db_info = array(
                "db_host" => DbConfig::DbConfigHost,
                "db_port" => DbConfig::DbConfigPort,
                "db_user" => DbConfig::DbConfigUser,
                "db_pass" => DbConfig::DbConfigPass,
                "db_name" => DbConfig::DbConfigName,
                "db_charset" => DbConfig::DbConfigCharset,
                "db_db" => DbConfig::DbConfigDatabase,
            );

            try {
                self::$instance = new PDO(
                    "mysql:host=" . $db_info['db_host'] .
                    ';port=' . $db_info['db_port'] .
                    ';dbname=' . $db_info['db_name'],
                    $db_info['db_user'], $db_info['db_pass']
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');
            } catch (PDOException $error) {
                echo $error->getMessage();
            }

        }

        return self::$instance;
    }

    public static function setCharsetEncoding()
    {
        if (self::$instance == null) {
            self::connect();
        }

        self::$instance->exec(
            "SET NAMES 'utf8';
			SET character_set_connection=utf8;
			SET character_set_client=utf8;
			SET character_set_results=utf8");
    }

}
