<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ReportController extends Controller
{

    public function report()
    {
        try {
            $items = \App\Models\Item::where('deleted', false)
                ->get();

            $html = view('inventory.pdf.report', [
                'date' => \Carbon\Carbon::now(),
                'items' => $items
            ])->render();

            $snappdf = new \Beganovich\Snappdf\Snappdf();

            $filename = '/public/inventory-report-' . \Carbon\Carbon::now()->format('Y-m-d') . '.pdf';

            $pdf = $snappdf
                ->setHtml($html)
                ->save($filename);

            return  response()->download($filename);

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['message' => 'Unable to generate report']);
        }
    }

    public function testReport()
    {
        try {

            $html = "Hello world";
            $snappdf = new \Beganovich\Snappdf\Snappdf();

             $snappdf
                ->setHtml($html)
                ->save('/');

            return  response()->download('/');

        }catch (\Exception $e){
            return  $e->getMessage();
        }
    }
}
