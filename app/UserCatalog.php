<?php

namespace App;

class UserCatalog {

    private $userList;

    function __construct($userListData) {
        $this->userList = array();

        $this->setUserList($userListData);
    }
    
    function setUserList($userListData) {
        //dd($eSListData);
        foreach ($userListData as $userData) {
            $user = new User($userData);
            array_push($this->userList, $user);
        }
    }
    
}