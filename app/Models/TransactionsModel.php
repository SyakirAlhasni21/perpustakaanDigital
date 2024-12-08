<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'TransactionID';
    protected $allowedFields = ['UserID', 'TransactionDate', 'Status'];
    protected $useTimestamps = false;
}
