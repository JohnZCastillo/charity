<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(1);

        return view('inventory.account', [
            'user' => $user
        ]);
    }
}
