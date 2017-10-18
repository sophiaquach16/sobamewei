<?php

namespace App\Classes\Core;

class UserCatalog {

    private $userList;

    function __construct() {
        $this->userList = array();
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($userListData) {
        $this->userList = array();

        $this->setUserList($userListData);
    }
    
    function setUserList($userListData) {
        //dd($userListData);
        foreach ($userListData as $userData) {
            $user = new User($userData);
            array_push($this->userList, $user);
        }
    }

    function getUserList() {
        $users = array();

        foreach ($this->userList as $user) {
            array_push($users, $user->get());
        }

        return $users;
    }
}