<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasCount
{
    public function scopeCount(Builder $query, Request $request)
    {
        if ($request->has('withCount') && !empty($request->withCount)) {
            $relationships = explode(',', $request->withCount);
            array_map('trim', $relationships);

            foreach ($relationships as $key => $value) {
                if (str_contains($value, ".")) {
                    continue;
                }

                if (!method_exists(__CLASS__, $value)) {
                    unset($relationships[$key]);
                }
            }

            return $query->withCount($relationships);
        }
    }
}
