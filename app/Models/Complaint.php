<?php

namespace App\Models;

use App\Traits\Causer;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model implements HasMedia
{
    use HasFactory, Causer, InteractsWithMedia;

    protected $guarded = [];

    public function complaint_type()
    {
        return $this->belongsTo(ComplaintType::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
