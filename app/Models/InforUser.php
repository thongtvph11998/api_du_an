<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InforUser extends Model
{
    use HasFactory;
     protected $table='infor_users';
    protected $primarykey='id';
    protected $fillable=[
        'user_id',
        'pro_id',
        'phone',
        'address',
        'birthday',
        'gender',
    ];
}
