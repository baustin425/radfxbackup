<?php

class Database {
	//protected function connect() {
	public function connect() {
		try {
			// Change this to your connection info.
			$DATABASE_USER = 'root';
			$DATABASE_PASS = '';
			$database = new PDO("mysql:host=localhost;dbname=radfx", $DATABASE_USER, $DATABASE_PASS);
			return $database;
		} catch(PDOException $e) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
			die();
		}
	}
}