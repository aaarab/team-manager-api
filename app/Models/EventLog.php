<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EventLog extends Model
{
    use HasFactory;

    public $timestamps = false ;

    protected $fillable = [
        'action',
        'attributes',
        'changes',
        'object_id',
        'object_type',
        'original',
        'request_method',
        'request_path',
        'causer_type',
        'causer_id',
        'created_at',
    ];

    protected $casts = [
        "attributes" => "json",
        "original" => "json",
        "changes" => "json",
    ];

    public function rules()
    {
        return [
            'action' => 'required|string|max:2045',
            'object_id' => 'required|integer',
            'object_type' => 'required|string|max:150',
            'original' => 'json',
            'attributes' => 'json',
            'changes' => 'json',
            'request_method' => 'required|string|max:150',
            'request_path' => 'required|string|max:150',
            'causer_type' => 'nullable|string|max:45',
            'causer_id' => 'nullable|integer',
        ] ;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public static function log($attributes): void
    {
        $event = new EventLog();
        $input = [
            ...$attributes,
            'request_method' => request()->getMethod(),
            'request_path' => request()->path(),
            'created_at' => Carbon::now(),
        ];

        $event->fill($input);

        $user = Auth::user();
        if ($user) {
            $event->fill([ 'causer_type' => 'user', 'causer_id' => $user->id ]);
        }

        $event->save();
    }
}
