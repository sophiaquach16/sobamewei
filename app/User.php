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

    /**
     * User constructor.
     */
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
        
        $returnData->id = $this->id;
        $returnData->firstName = $this->firstName;
        $returnData->lastName = $this->lastName;
        $returnData->email = $this->email;
        $returnData->phone = $this->phone;
        $returnData->admin = $this->admin;
        $returnData->physicalAddress = $this->physicalAddress;
        $returnData->password = $this->password;
        
        return $returnData;
    }

}
