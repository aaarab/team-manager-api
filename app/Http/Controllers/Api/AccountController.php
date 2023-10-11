<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Traits\HasController;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use HasController;

    protected $model = Account::class;

    public function destroy($id)
    {
        $account = Account::withCount('employers')->findOrFail($id);

        if ($account->employers_count) {
            return response()->json(['message' => 'you can not delete this account'], 400);
        }

        $account->delete();

        return $account;
    }
}
