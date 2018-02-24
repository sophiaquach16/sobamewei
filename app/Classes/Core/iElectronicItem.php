<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-23
 * Time: 11:09 PM
 */

namespace App\Classes\Core;


interface iElectronicItem
{
    public function getElectronicSpecification_id();

    public function getExpiryForUser();

    public function getSerialNumber();

    public function getId();

    public function getUserId();

    public function set($data);

    public function setExpiryForUser($expiry);

    public function setSerialNumber($serialNumber);

    public function setUserId($userId);
}