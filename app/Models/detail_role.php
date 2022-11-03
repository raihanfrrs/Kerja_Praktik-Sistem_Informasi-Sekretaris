<?php

namespace App\Models;

use App\Models\role;
use App\Models\dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detail_role extends Model
{
    use HasFactory;

    protected $table = 'detail_roles';

    protected $guarded = [
        'id'
    ];

    public function dosen(){
        return $this->belongsTo(dosen::class, 'dosen_id', 'id');
    }

    public function role(){
        return $this->belongsTo(role::class, 'role_id', 'id');
    }
}
