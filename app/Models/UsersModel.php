<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'UserID';
    protected $allowedFields = ['UserId', 'Username', 'FullName', 'Email', 'Phone', 'password', 'DateCreated'];
}
