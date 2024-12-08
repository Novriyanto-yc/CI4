<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipModel extends Model
{
    protected $table = 'coconut_ship';               // Table name
    protected $primaryKey = 'id';            // Primary key
    protected $allowedFields = ['name', 'is_visible']; // Fields that can be mass-assigned
    protected $useTimestamps = true;         // Enable `created_at` and `updated_at`
}

?>