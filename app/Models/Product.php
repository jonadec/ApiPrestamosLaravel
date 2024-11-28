<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code', 'name', 'category', 'quantity', 'description', 'image_url'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
