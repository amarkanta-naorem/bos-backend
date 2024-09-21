<?php

namespace App\Traits;

trait CreatedUpdatedDeletedBy
{
    protected static function bootCreatedUpdatedDeletedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (auth()->check()) {
                if (!$model->isDirty('created_by')) {
                    $model->created_by = auth()->user()->id;
                }
                if (!$model->isDirty('updated_by')) {
                    $model->updated_by = auth()->user()->id;
                }
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (auth()->check() && !$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // deleting deleted_by when model is deleted
        static::deleting(function ($model) {
            if (auth()->check() && !$model->isDirty('deleted_by')) {
                $model->deleted_by = auth()->user()->id;
                $model->save();
            }
        });
    }
}
