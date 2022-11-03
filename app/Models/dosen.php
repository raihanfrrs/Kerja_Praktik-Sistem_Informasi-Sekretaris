<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $guarded = [
        'id'
    ];

    public function detail_role(){
        return $this->belongsTo(detail_role::class, 'id');
    }
}
