<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\Donation;
use App\Models\Item;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $donutChartIds = [];
        $donutChartHeader = [];
        $donutChartValues = [];
        $newItemsCount = [];
        $lineChartLabel = [];

        $donors = Account::select(DB::raw('COUNT(id) as total_count'))
            ->where('type', UserType::DONOR->value)
            ->where('status', UserStatus::ENABLED->value)
            ->groupBy('id')
            ->value('total_count');

        $recipients = Account::select(DB::raw('COUNT(id) as total_count'))
            ->where('type', UserType::RECIPIENT->value)
            ->where('status', UserStatus::ENABLED->value)
            ->groupBy('id')
            ->value('total_count');

        $items = Item::select(DB::raw('COUNT(id) as total_count'))
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->groupBy('id')
            ->value('total_count');

        $lowStockItems = Item::select(['id', 'stock', 'name', 'code'])
            ->where('deleted', false)
            ->where('stock', '<=', 100)
            ->where('status', ItemStatus::ENABLED->value)
            ->orderby('stock')
            ->take(5)
            ->get();

        $itemsStock = Item::select(['id', 'name' ,'stock', DB::raw('COUNT(id) as total_count')])
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->groupBy('id', 'name','stock')
            ->orderBy('stock', 'DESC')
            ->take(5)
            ->get();

        $othersItemStock = Item::select([DB::raw('SUM(stock) as total_stock')])
            ->whereIn('id',$donutChartIds)
            ->where('deleted', false)
            ->where('status', ItemStatus::ENABLED->value)
            ->value('total_stock');

        foreach ($itemsStock as $index => $item) {
            $donutChartIds[$index] = $item->id;
            $donutChartHeader[$index] = $item->name;
            $donutChartValues[$index] = $item->stock;
        }

        if($othersItemStock){
            $donutChartHeader[count($donutChartIds)] =  'Others';
            $donutChartValues[count($donutChartIds)] =  $othersItemStock;
        }

        $months = [];
        $donatedItems = [];

        $period = CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now());

        foreach ($period as $index => $date) {
            $months[$index] = $date->format('M');

            $donatedItems[$index] = Donation::select([DB::raw('SUM(quantity) as donation')])
                ->whereDate('created_at', '>=', $date->firstOfMonth()->format('Y-m-d H:i'))
                ->whereDate('created_at', '<=', $date->endOfMonth()->format('Y-m-d H:i'))
                ->value('donation') ?? 0;

            $newItemsCount[$index] = Item::select([DB::raw('COUNT(id) as total')])
                ->whereDate('created_at', '>=', $date->firstOfMonth()->format('Y-m-d H:i'))
                ->whereDate('created_at', '<=', $date->endOfMonth()->format('Y-m-d H:i'))
                ->value('total');

            $lineChartLabel[$index] = $date->format('Y-m');

        }

        return view('dashboard', [
            'donors' => $donors,
            'recipients' => $recipients,
            'items' => $items,
            'lowStockItems' => $lowStockItems,
            'donutChartHeaders' => $donutChartHeader,
            'donutChartValues' => $donutChartValues,
            'barChartLabels' => $months,
            'barChartValues' => $donatedItems,
            'newItemsCount' => $newItemsCount,
            'lineChartLabel' => $lineChartLabel
        ]);
    }
}
