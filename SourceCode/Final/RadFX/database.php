<?php
/**
 * Connects to the database using information from a config file
 * @author ETurner
 */
class Database {
	public function connect() {
		try {
			include_once "../../../data/Config.php";
			$config = new Config();//the config file with the database log in info

			$DATABASE_USER = $config->getUser();
			$DATABASE_PASS = $config->getPassword();
			$DATABASE_INFO = $config->getDbname();
			$database = new PDO($DATABASE_INFO, $DATABASE_USER, $DATABASE_PASS);
			return $database;
		} catch(PDOException $e) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
			die();
		}
	}
}
