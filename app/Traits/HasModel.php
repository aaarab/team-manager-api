<?php

namespace App\Traits;

use App\Exceptions\InvalidDataException;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait HasModel {
    use HasRelationships;
    use HasCount;
    use SoftDeletes;

    protected static function booted()
    {
        static::created(function ($model) {
            $model->created_by = Auth::user() ? Auth::user()->id : null;
            if (method_exists($model, 'bootCreated')) {
                $model->bootCreated();
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user() ? Auth::user()->id : null;
            if (method_exists($model, 'bootUpdating')) {
                $model->bootUpdating();
            }
        });

        static::saving(function ($model) {
            self::validate($model);
        });

        static::deleting(function ($model) {
            if (method_exists($model, 'bootDeleting')) {
                $model->bootDeleting();
            }
        });

        static::updated(function ($model) {
            if (method_exists($model, 'bootUpdated')) {
                $model->bootUpdated();
            }
        });
    }

    private static function validate($model)
    {
        if (!method_exists(__CLASS__, 'rules')) :
            throw new Exception('rules method dos not exist on ' . __CLASS__ . ' class');
        endif;

        $validator = Validator::make($model->attributes, $model->rules());

        if ($validator->fails()) :
            throw (new InvalidDataException())->withErrors($validator->errors());
        endif;
    }
}
