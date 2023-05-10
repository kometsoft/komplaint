<?php

namespace App\Models;

use App\Traits\Causer;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model implements HasMedia
{
    use HasFactory, Causer, InteractsWithMedia, SoftDeletes;

    protected $guarded = [];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function action()
    {
        return $this->hasOne(Action::class)->latestOfMany();
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
