<?php

namespace App\Traits;

use App\Models\User;

trait Causer
{
    public static function bootCauser()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => '—']);
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(['name' => '—']);
    }
}
