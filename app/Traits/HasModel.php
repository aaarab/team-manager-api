<?php

namespace App\Traits;

use App\Exceptions\InvalidDataException;
use App\Models\EventLog;
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
        static::creating(function ($model) {
            $model->created_by = Auth::user() ? Auth::user()->id : null;
            if (method_exists($model, 'bootCreating')) {
                $model->bootCreating();
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

        static::created(function ($model) {
            if (method_exists($model, 'bootCreated')) {
                $model->bootCreated();
            }
            self::log($model, 'create');
        });


        static::updated(function ($model) {
            if (method_exists($model, 'bootUpdated')) {
                $model->bootUpdated();
            }
            self::log($model, 'update');
        });

        static::deleted(function ($model) {
            self::log($model, 'delete');
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

    private static function log($model, $action)
    {
        $event = [
            "object_type" => $model->getTable(),
            "object_id" => $model->id,
            "action" => $action,
            "attributes" => $model->attributes,
            "original" => $model->original,
            "changes" => $model->changes,
        ];

        EventLog::log($event);
    }
}
