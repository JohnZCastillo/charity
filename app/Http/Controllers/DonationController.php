<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{

    public function donate(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'recipient_id' => 'required',
                'item_id' => 'required',
                'quantity' => 'required|numeric',
            ]);

            Donation::create($validated);

            $item = Item::findOrFail($validated['item_id']);

            if ($validated['quantity'] > $item->stock) {
                throw new \Exception('Invalid Amount');
            }

            $item->update(['stock' => $item->stock - $validated['quantity']]);

            DB::commit();

            return redirect()->back()->with(['message' => 'Donation Success!']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $exception->getMessage()]);
        }
    }
}
