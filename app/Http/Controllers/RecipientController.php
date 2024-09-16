<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RecipientController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::query();

        $query->when($request->input('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereLike('code', '%' . $request->input('search') . '%');
                $query->orWhereLike('name', '%' . $request->input('search') . '%');
                $query->orWhereLike('email', '%' . $request->input('search') . '%');
                $query->orWhereLike('mobile', '%' . $request->input('search') . '%');
            });
        });

        $query->when($request->input('status'), function ($query) use ($request) {
            $query->where('status', $request->input('status'));
        });

        $query->when($request->input('order'), function ($query) use ($request) {
            $query->orderBy($request->input('order'), $request->input('sort'));
        });

        $query->whereIn('type', [UserType::RECIPIENT->value]);
        $query->with(['address']);

        $recipients = $query->paginate();

        return view('recipients', [
            'recipients' => $recipients,
        ]);
    }

    public function addRecipient(Request $request)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'code' => 'required|unique:accounts',
                'name' => 'required|string',
                'mobile' => 'required|string',
                'email' => 'required|email|unique:accounts',
                'status' => [Rule::enum(UserStatus::class)],
                'address' => 'required|string',
            ]);

            $validated['type'] = UserType::RECIPIENT->value;

            $account = Account::create($validated);

            Address::create([
                'account_id' => $account->id,
                'address' => $validated['address'],
            ]);

            DB::commit();

            return redirect()->back()->with(['message' => 'Recipient account created']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Unable to create recipient account']);
        }
    }
}
