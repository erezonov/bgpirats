<?php

namespace App\Http\Controllers;

use App\Http\Requests\KickstarterLotRequest;
use App\Http\Requests\KickstarterRequest;
use App\Models\Kickstarter;
use App\Models\Kickstarter_pledges;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KickstarterController extends Controller
{
    //
    public function showKickstarter()
    {
        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
        $kickstarter = Kickstarter::all()->map(
            fn($kick) => $kick->only(['id', 'name', 'price', 'url', 'comment', 'comment2']))
            ->values();
        foreach ($kickstarter as $kick ) {
            $btnDetails = '<a href="/admin/kickstarter/view/'.$kick['id'].'" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </a>';
            array_push($kick, $btnDetails);
            $data[] = $kick;

        }
        $dataFinal = $data;
        $user = auth()->user()->id ?? 0;
        $config = [
            'data' => [$data],
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false, 'user' => $user ?? 1]],
        ];
        return view('kickstarter.admin.index', ['kick' => $dataFinal, 'config']);
    }

    public function addKickstarter()
    {
        return view('kickstarter.admin.add');
    }

    public function saveKickstarter(KickstarterRequest $request)
    {
        $data = $request->validated();
        $kick = Kickstarter::firstOrCreate(['name' => $data['name']]);
        $kick->update($data);

        $kick->save();
        return '/admin/kickstarter/view/'.$kick->id;
    }

    public function viewKickstarter($id) {
        $kickstarter = Kickstarter::with('lots')->find($id);
        $user = auth()->user()->id ?? 0;
        return view('kickstarter.admin.view', ['kick' => $kickstarter, 'user'=> $user]);
    }

    public function saveLot(KickstarterLotRequest $request) {
        $data = $request->validated();
        $data['kick_id'] = $data['kick_id'];
        $data['code'] = md5(time());
        $kick = new Kickstarter_pledges();
        $kick->fill($data);
        $kick->save();
        return response()->json($kick);
    }

    public function addToOrder(Request $request) {
        $order = new Orders();
        $order->fill($request->all());
        $order->save();

        return true;
    }
}
