<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'CartID';
    protected $allowedFields = ['UserID', 'ISBN', 'Quantity', 'DateAdded'];
}
