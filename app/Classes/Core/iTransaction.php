<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 3:38 PM
 */

namespace app\Classes\Core;


interface iTransaction
{
    public function get();

    public function getTimeStamp();

    public function purchase($userId);

    public function setTimeStamp($time);

    public function set($time);
}