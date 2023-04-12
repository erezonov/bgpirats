<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //
    public function index() {
        $packages = Packages::all();
      //  dd($packages);
        return view('packages.admin.index', ['packages' => $packages]);
    }

    public function save(Request $request) {
        $packages = new Packages();
        $packages->fill($request->all());
        $packages->save();
        return true;
    }

    public function show($id) {
        $packages = Packages::with('orders')
            ->with('orders.user')
            ->find($id);
        $packages->statusText = Packages::STATUSTEXT[$packages->status];
        return view('packages.admin.view', ['package' => $packages]);
    }
}
