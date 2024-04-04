<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
// use App\Models\Accomplishment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Product;
use App\Models\AreaOfAssignment;
use App\Models\ItineraryHead;
use App\Models\AccomplishmentHead;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function iindex()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        $itinerary = ItineraryHead::where('user_id', $user->id)
            ->whereDoesntHave('itineraries')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($itinerary as $i) {
            $i->delete();
        }

        $this->deleteUnnecessaryItineraryHeads($user);

        $itinerary = ItineraryHead::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $lastItinerary = ItineraryHead::where('user_id', $user->id)->latest()->first();
        if($lastItinerary){
        $Itinerary_accomplishment = AccomplishmentHead::where('itin_head',  $lastItinerary->id)->first(); 
        }
        else{
            $Itinerary_accomplishment= '';
        }
        return view('itinerary', compact('itinerary', 'user', 'accounts','products', 'lastItinerary', 'Itinerary_accomplishment'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    private function deleteUnnecessaryItineraryHeads($user)
{
    $itineraryHeads = ItineraryHead::where('user_id', $user->id)
        ->where('status', 'Pending')
        ->orderBy('date_from', 'desc')
        ->groupBy('date_from')
        ->selectRaw('max(id) as id, date_from')
        ->get();

    $itineraryHeadIdsToKeep = $itineraryHeads->pluck('id')->toArray();

    ItineraryHead::whereNotIn('id', $itineraryHeadIdsToKeep)
        ->where('user_id', $user->id)
        ->where('status', 'Pending')
        ->delete();
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function icreate()
    {
        $products = Product::all();
        $accounts = Account::all();
        return view('createitin', compact('accounts', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'name_of_coop' => 'required',
            'municipality' => 'required',
            'account_id' => 'required',
            'purpose' => 'required',
            'product_id' => 'required',
            'remarks' => '',
        ]);

        $input = $request->all();

        Itinerary::create($input);
        
       // Accomplishment::create($input);           //If permitted the itinerary_id column will be dropped.
        
        return redirect()->route('iindex')->with('success', 'Itinerary Created Succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function show(Itinerary $itinerary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function edit(Itinerary $itinerary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Itinerary $itinerary)
    {
        //
    }
}
