<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class role extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [
        'id'
    ];

    public function detail_role(){
        return $this->hasMany('App\Models\detail_role');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'role'
            ]
        ];
    }
}
