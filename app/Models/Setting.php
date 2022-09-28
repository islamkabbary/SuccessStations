<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'whatsapp', 'terms', 'policy', 'advertising', 'country_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
