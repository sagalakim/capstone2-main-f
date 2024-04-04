<?php

namespace App\Http\Controllers;

use App\Models\Liquidation;
use App\Models\CashAdvance;
use Illuminate\Http\Request;

class LiquidationController extends Controller
{
    public function lindex()
    {
        $liquidation = Liquidation::latest()->paginate(5);

        return view('liquidation', compact('liquidation'))->with('i',(request()->input('page',1)-1)*5);
    }

    public function lcreate()
    {
        return view('createliquid');
    }

    public function lstore(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'travel_itinerary' => 'required',
            'reference' => 'required',
            'particulars' => 'required',
            'total' => '',
        ]);

        $input = $request->all();

        Liquidation::create($input);

        return redirect()->route('lcreate')->with('success', 'Itinerary Created Succesfully');
    }

    public function show(Liquidation $liquidation)
    {
        return view('showliquid', compact('liquidation'));
    }

    public function edit(Liquidation $liquidation)
    {
        return view('editliquid', compact('liquidation'));
    }

    public function update(Request $request, Liquidation $liquidation) 
    {
        $request->validate([
            'travel_itinerary' => 'required',
            'reference' => 'required',
            'particulars' => 'required',
            'total' => '',
        ]);

        $input = $request->all();

        $liquidation->update($input);

        return redirect()->route('lindex')->with('success','Liquidation updated successfully!');
    }
/*
    public function ca(Request $request, Liquidation $liquidation){
        return view('vca');
    }

    public function cca(Request $request, Liquidation $liquidation){
        $request->validate([
            'amount' => '',
        ]);

        $input = $request->all();
        $ca = CashAdvance::create($input);
        $liquidation->update($input);
        return redirect()->route('index');
    }
*/
}
