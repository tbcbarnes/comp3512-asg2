<?php
/**
 * Used to store and track information regarding a user.
 * 
 * Upon initialization, check if user exists. If not, return error.
 * Check password, if wrong, return error.
 * Load all user info into variables
 */
 
class User {
    private $userData;
    private $username;
    private $dateJoined;
    private $dateLastModified;

    
    public function __construct($userLoginInfo,$userDataIn) {
        $this->userData = $userDataIn;
        $this->username = $userLoginInfo['UserName'];
        $this->dateJoined = $userLoginInfo['DateJoined'];
        $this->dateLastModified = $userLoginInfo['DateLastModified'];
    }
    
    public function getUserData() {
        return $this->userData;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getDateJoined() {
        return $this->dateJoined;
    }
    
    public function getDateLastModified() {
        return $this->dateLastModified;   
    }

    public function getUserID() {
        return $this->userData['UserID'];
    }
}