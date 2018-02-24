<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 4:18 PM
 */

namespace app\Classes\Core;


interface iUserCatalog
{
    public function setUserList($userListData);

    public function getUserList();

    public function checkUser($email, $password);

    public function findUser($email);

    public function makeCustomer($userData);

    public function getDeleteUserInfo($userId);
}