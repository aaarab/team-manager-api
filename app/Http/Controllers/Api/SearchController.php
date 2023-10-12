<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        $ability = "search.create";
        $this->authorize($ability, Auth::user());

        $value = strtoupper(request()->value);

        if (request()->has('value') && !empty($value)) {

            $accounts = Account::where(DB::raw('upper(name)'), 'LIKE', '%' . $value . '%')->get();

            $employers = Employer::where(DB::raw('upper(name)'), 'LIKE', '%' . $value . '%')->get();

            return compact('accounts', 'employers');
        }
    }
}
