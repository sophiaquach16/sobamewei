<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 2:56 PM
 */

namespace app\Classes\Core;


interface iElectronicCatalog
{
    public function addReturnedEI($item_id, $serialNumber, $ElectronicSpecification_id);

    public function deleteElectronicItem($id);

    public function findElectronicSpecification($modelNumber);

    public function getElectronicSpecificationById($id);

    public function getESList();

    public function getESListFromEIList($eIList);

    public function makeElectronicItem($modelNumber, $electronicItemData);

    public function makeElectronicSpecification($electronicSpecificationData);

    public function modifyElectronicSpecification($eSId, $newESData);

    public function reserveFirstEIFromES($eSId, $userId, $expiry);

    public function setESList($esListData);

    public function unsetUserAndExpiryFromEI($eSId, $userId);
}