<?php

namespace user;

class User {
    
    public static $username     = NULL;
    public static $email        = NULL;
    public static $role         = NULL;
    public static $isLoged      = false;
    
    // ???
    // TODO : think about the designe
    public function set($userObject) {
        
        echo "<br>";
        echo " debug set";
        echo "<br>";
        
        User::$username = $userObject['username'];
        User::$email    = $userObject['email'];
        User::$role     = $userObject['role'];
        User::$isLoged  = true;
    }

    public static function login($email, $password) {
        
        if(User::isAvailable($email, $password)) {
            
            $queryResult = \db\Database::getInstance()->query("SELECT * FROM cms.users WHERE email = '{$email}' AND password = '{$password}'");
            return \db\Database::getInstance()->fetch();            
        }
        
        return false;
    }
        
    public static function isAvailable($email, $password) {
        
        // NB NB NB NB NB NB
        \db\Database::getInstance()->query("SELECT COUNT(*) AS number_of_rows FROM cms.users WHERE email = '{$email}' AND password = '{$password}'");
        $collection = \db\Database::getInstance()->fetch();

        return ($collection['number_of_rows'] == 1);        
    }


    // NB: return User object 
    // NB : who is going to manage the session
    public static function registration($username, $email, $password) {
        
        \db\Database::getInstance()->query("INSERT INTO cms.users(username, email, password, role) 
                        VALUES('{$username}', '{$email}', '{$password}', 1)");
                        
        if(\db\Database::getInstance()->lastInsertedId()) {
            return true;
        }
        
        return false;
    }
    
    public static function logout() {
        // TODO         
    }
}