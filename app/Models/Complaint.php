<?php

namespace App\Models;

use App\Traits\Causer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory, Causer;

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
