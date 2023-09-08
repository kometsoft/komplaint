<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $guarded = [];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function action()
    {
        return $this->hasOne(Action::class)->latestOfMany();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => '—']);
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(['name' => '—']);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
