<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'coconut_transaction';               // Table name
    protected $primaryKey = 'id';            // Primary key
    protected $allowedFields = ['cargo_id', 'user_id', 'muatan_kg', 'komisi_in_rp',
        'total_komisi_in_rp', 'total_muatan_in_rp', 'nama_petani', 'tanggal_muatan', 'status']; // Fields that can be mass-assigned
    protected $useTimestamps = true;         // Enable `created_at` and `updated_at`

    public function getUnfinishedCargo($id, $date)
    {
        $s = $this->select('coconut_transaction.*, coconut_ship.name, coconut_user.id as user_id, coconut_user.name as username')
                ->join('coconut_cargo', 'coconut_cargo.id = coconut_transaction.cargo_id', 'LEFT')
                ->join('coconut_ship', 'coconut_ship.id = coconut_cargo.ship_id', 'LEFT')
                ->join('coconut_user', 'coconut_user.id = coconut_transaction.user_id', 'LEFT')
                ->where('coconut_cargo.is_completed', 0)
                ->where('DATE(coconut_cargo.created_at)', $date)
                ->where('coconut_user.id', $id)->findAll();
        return $s;
    }
}

?>