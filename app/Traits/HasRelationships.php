<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasRelationships
{

    public function scopeRelationships(Builder $query, Request $request)
    {
        if ($request->has('with') && !empty($request->with)) {
            $relationships = explode(',', $request->with);
            array_map('trim', $relationships);

            foreach ($relationships as $key => $value) {
                if (str_contains($value, ".")) {
                    continue;
                }

                if (!method_exists(__CLASS__, $value)) {
                    unset($relationships[$key]);
                }
            }
            // Eager Loading
            return $query->with($relationships);
        }
    }
}
