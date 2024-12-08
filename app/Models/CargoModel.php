<?php

namespace App\Models;

use CodeIgniter\Model;

class CargoModel extends Model
{
    protected $table = 'coconut_cargo';               // Table name
    protected $primaryKey = 'id';            // Primary key
    protected $allowedFields = ['ship_id', 'user_id', 'total_ship_cargo', 'is_completed']; // Fields that can be mass-assigned
    protected $useTimestamps = true;         // Enable `created_at` and `updated_at`

    public function getUnfinishedCargo($id, $date)
    {
        $s = $this->select('coconut_cargo.*, coconut_ship.name, coconut_user.id as user_id, coconut_user.name as username')
                ->join('coconut_ship', 'coconut_ship.id = coconut_cargo.ship_id', 'LEFT')
                ->join('coconut_user', 'coconut_user.id = coconut_cargo.user_id', 'LEFT')
                ->where('coconut_cargo.is_completed', 0)
                ->where('DATE(coconut_cargo.created_at)', $date)
                ->where('coconut_user.id', $id)->findAll();
        return $s;
    }
    
    public function getAllUnfinishedCargo($date)
    {
        $s = $this->select('coconut_cargo.*, coconut_ship.name, coconut_user.id as user_id, coconut_user.name as username')
                ->join('coconut_ship', 'coconut_ship.id = coconut_cargo.ship_id', 'LEFT')
                ->join('coconut_user', 'coconut_user.id = coconut_cargo.user_id', 'LEFT')
                ->where('DATE(coconut_cargo.created_at)', $date)
                ->where('coconut_cargo.is_completed', 0)
                ->findAll();
        return $s;
    }

    // public function updateCargoStatus($id, $value)
    // {
    //     return $this->update($id, ['is_completed' => $value]);
    // }
}

?>