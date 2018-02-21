<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\UserCatalogTDG;
use App\Classes\Core\UserCatalog;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use Hash;

class UserCatalogMapper {

    public $userCatalog;
    public $userCatalogTDG;
    public $unitOfWork;
    public $identityMap;
    public $lockFilePointer;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }

    function __construct0() {
        $this->userCatalogTDG = new userCatalogTDG();
        $this->userCatalog = new userCatalog($this->userCatalogTDG->findAll());
        $this->unitOfWork = new UnitOfWork(['userCatalogMapper' => $this]);
        $this->identityMap = new IdentityMap();
    }

    function saveUser($user) {
        return $this->userCatalogTDG->add($user);
    }

    function makeLoginLog($id) {
        date_default_timezone_set('EST');
        $timestamp = date("Y-m-d H:i:s");

        $this->userCatalogTDG->insertLoginLog($id, $timestamp);
        return true;
    }

    function makeNewCustomer($userData) {
        $userData->admin = "0";
        $emailExists = $this->userCatalog->findUser($userData->email);

        if (!$emailExists) {
            $userData->password = Hash::make($userData->password);

            $user = $this->userCatalog->makeCustomer($userData);


            $this->unitOfWork->registerNew($user);
            $this->unitOfWork->commit();


            //Add to identity map
            $this->identityMap->add('User', $user);

            return true;
        } else {
            return false;
        }
    }

    function login($email, $password){
        if($this->userCatalog->checkUser($email, $password)){
            return true;
        }else{
            return $this->userCatalogTDG->login($email, $password);
        }
    }

    function deleteUser($userId){
        $message = "";
        try{
            $this->lockFilePointer = fopen(app_path('Locks/dataAccess'), 'c');
            flock($this->lockFilePointer, LOCK_EX);
        }catch(\Exception $e){
        }

        $this->identityMap->delete('User', 'id', $userId);
        $user=$this->userCatalog->getDeleteUserInfo($userId);

        if($user != null) {
          $this->unitOfWork->registerDeleted($user);
          $this->unitOfWork->commit();
          $message = "userDeleteSuccess";
        }
        else {
          $message = "userDeleteFailure";
        }
        
        try{
            flock($this->lockFilePointer, LOCK_UN);
            fclose($this->lockFilePointer);
        }catch(\Exception $e){
        }

        return $message;
    }

    function deleteCurrentUser($user){
        $userId=$user->get()->id;

        $this->userCatalogTDG->unsetUserEI($userId);
        $this->userCatalogTDG->deleteLoginLog($userId);
        $this->userCatalogTDG->deleteUserTransaction($userId);
        return $this->userCatalogTDG->deleteUser($user);
    }

    function getAllUsers(){

        $users = $this->userCatalog->getUserList();

        return $users;
    }
}
