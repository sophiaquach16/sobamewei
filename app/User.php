<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

use Notifiable;

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $admin;
    private $physicalAddress;
    private $password;

	//source for multiple constructors: http://www.webtrafficexchange.com/multiple-constructors-php
	function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
         }
    }
 
    function __construct1($data) {
		$this->set($data);
    }

    public function set($data) {
        $this->id = $data->id;
        $this->firstName = $data->firstName;
        $this->lastName = $data->lastName;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->admin = $data->admin;
        $this->physicalAddress = $data->physicalAddress;
        $this->password = $data->password;
    }
    
    public function get(){
        $returnData = new \stdClass();
        
        $returnData->id = $thid->id;
        $returnData->firstName = $thid->firstName;
        $returnData->lastName = $thid->lastName;
        $returnData->email = $thid->email;
        $returnData->phone = $thid->phone;
        $returnData->admin = $thid->admin;
        $returnData->physicalAddress = $thid->physicalAddress;
        $returnData->password = $thid->password;   
        
        return $returnData;
    }

}
