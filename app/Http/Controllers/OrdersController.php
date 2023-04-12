<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Packages;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //

    public function index()
    {
        $orders = Orders::with('user')
            ->with('lot.kickName')
            ->with('package')
            ->get()
            ->map( function ($item) {
                $text = '';
                if($item->status == 3) {
                    $text = Packages::find($item->package_id)->name;
                }
                return $item->setAttribute('StatusText', Orders::ALLSTATUSES[$item->status]." ".$text);
            })
            ;
        $packages = Packages::all();

        return view('orders.admin.index', ['orders' => $orders, 'packages' => $packages]);
    }

    public function addToPackage(Request $request)
    {
        $orders = Orders::find($request->id_order_val);
        $orders->package_id = $request->package;
        $orders->status = Orders::STATUS_IN_PACK;
        $orders->save();
        dd($request);
    }
}
