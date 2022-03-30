<?php

namespace App\Models\location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $primaryKey = 'r_i';
    protected $table = 't_locations';
    protected $fillable = ['r_i','r_client','r_num','r_mnt_total','r_status','r_mnt_logistik','r_destination','r_remise','r_montant','r_logistik'];
}
