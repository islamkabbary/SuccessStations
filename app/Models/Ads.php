<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'image'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'ads_countries');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_ads');
    }
}
