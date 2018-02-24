<?php

namespace App\Classes\Core;

use Hash;

class UserCatalog
{

    private $userList;

    function __construct()
    {
        $this->userList = array();
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }

    function __construct1($userListData)
    {
        $this->userList = array();

        $this->setUserList($userListData);
    }

    function setUserList($userListData)
    {
        //dd($userListData);
        foreach ($userListData as $userData) {
            $user = new User($userData);
            array_push($this->userList, $user);
        }
    }

    function getUserList()
    {
        $users = array();

        foreach ($this->userList as $user) {
            array_push($users, $user->get());
        }

        return $users;
    }

    function checkUser($email, $password)
    {

        foreach ($this->userList as $user) {
            if ($user->get()->email === $email) {
                if (Hash::check($user->get()->password, $password)) {
                    return true;
                }

                break;
            }
        }

        return false;

    }

    function findUser($email)
    {
        $emailExists = false;
        foreach ($this->userList as $user) {
            if ($user->get()->email === $email) {
                $emailExists = true;
                break;
            }
        }
        return $emailExists;
    }

    function makeCustomer($userData)
    {

        $user = new User($userData);

        array_push($this->userList, $user);
        return $user;
    }

    function getDeleteUserInfo($userId){
        foreach ($this->userList as $user) {
            if ($user->get()->id === $userId) {

                break;
            }
        }
        return $user;
    }
}
