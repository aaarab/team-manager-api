<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventLog;
use Illuminate\Support\Facades\Validator;

class EventLogController extends Controller
{
    public function index()
    {
        $validator = Validator::make(request()->all(),
            [
                'object_type' => 'required|string',
                'object_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $object_type = request()->object_type;
        $object_id = request()->object_id;
        $logs = EventLog::where(['object_type' => $object_type, 'object_id' => $object_id])->with('creator.roles')->get();
        return $logs;
    }
}
