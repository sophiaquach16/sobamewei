<?php

namespace App\Classes\Mappers;

use App\Classes\TDG\TransactionTDG;
use App\Classes\Core\TransactionCatalog;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use Hash;

class TransactionMapper {

    private $transactionCatalog;
    private $transactionTDG;
    private $unitOfWork;
    private $identityMap;

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
        }
    }

    function __construct0() {
        $this->transactionTDG = new transactionTDG();
        $this->transactionCatalog = new transactionCatalog($this->transactionTDG->findAll());
        $this->unitOfWork = new UnitOfWork(['transactionCatalog' => $this]);
        $this->identityMap = new IdentityMap();
    }

    function getAllTransactions($user_id) {

        $transactions= $this->transactionCatalog->getTransactionListForUser($user_id);

        return $transactions;
    }
}
