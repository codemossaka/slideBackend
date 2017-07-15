<?php

/**
 * Created by PhpStorm.
 * User: peyagodson
 * Date: 7/15/2017
 * Time: 6:06 PM
 */



class Database
{
    private static $connectionParams = null; // ['host' => '', 'dbname' => '', 'user' => '', 'pwd' => '']
    private static $connection = null;

    public static function init()
	{
		self::$connectionParams = include_once 'config.php';
        self::connect();
//    	if (self::connect()) {
//			echo "ok";
//		}
	}

    public static function query($query, $data = [])
	{
		$prepare = self::$connection->prepare($query);
		$prepare->execute($data);
		return $prepare;
	}

    private static function connect()
	{
        if (self::$connection == null) {
            try {
                self::$connection = new PDO(
                	'mysql:host='.self::$connectionParams['host'].
					';dbname='.self::$connectionParams['dbname'].
					';charset=utf8',
                    self::$connectionParams['user'],
					self::$connectionParams['pwd']
				);
            } catch (PDOException $e){
                die('Error '. $e->getMessage());
            }
        }

        return self::$connection;

    }
}