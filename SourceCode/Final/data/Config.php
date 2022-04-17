<?php
/**
 * Stores the login and database information for the server
 * @author ETurner
 */
class Config {
    private $username;
    private $password;
    private $dbname;
    private $email_username;
    private $email_password;

    /**
     * the constructor class
     */
    public function __construct() {
        $this->username = '<username>';
        $this->password = '<password>';
        $this->dbname = 'mysql:host=<hostname>;dbname=<datbase_name>;';

        $this->email_username = '<emailAddress>'; // YOUR gmail email
        $this->email_password = '<emailPassword>'; // YOUR gmail password
    }

    /**
     * the getters for all the variables for the config class
     */
    public function getUser() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getDbname() { return $this->dbname; }
    public function getEmailUser() { return $this->email_username; }
    public function getEmailPassword() { return $this->email_password; }
}