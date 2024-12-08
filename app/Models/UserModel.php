<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'coconut_user';               // Table name
    protected $primaryKey = 'id';            // Primary key
    protected $allowedFields = ['name', 'email', 'saldo', 'password', 'user_type']; // Fields that can be mass-assigned
    protected $useTimestamps = true;         // Enable `created_at` and `updated_at`

    // Define the custom method to find a user by email
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}

?>