<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = Account::findOrFail(1);

        return view('inventory.account', [
            'user' => $user
        ]);
    }
}
