<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Models\Item;
use App\Models\ItemAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request)
    {

        $query = Item::query();

        $query->with('attachment', function ($query) {
            $query->select(['file', 'item_id']);
        });

        $query->where('deleted','=',0);

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('items.code', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.name', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.description', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.stock', '%' . $request->input('search') . '%');
                $qb->orWhereLike('items.status', '%' . $request->input('search') . '%');
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy($request->input('order'), $request->input('sort'));
        });

        return view('item', [
            'items' => $query->paginate(20)
        ]);
    }

    public function addItem(Request $request)
    {
        $itemDetails = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'status' => [Rule::enum(ItemStatus::class)],
            'stock' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            $item = Item::create($itemDetails);

            if ($request->file('image')) {
                ItemAttachment::create([
                    'file' => $request->file('image')->store('public'),
                    'item_id' => $item->id
                ]);
            }

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }

    }

    public function deleteItem(Item $item)
    {

        try {
            DB::beginTransaction();

            $item->deleted = true;
            $item->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }

    }
}
