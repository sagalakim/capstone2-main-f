<?php

namespace App\Http\Controllers\Agent;

use App\Models\Itinerary;
use App\Http\Controllers\Controller;
use App\Models\Accomplishment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Product;
use App\Models\AreaOfAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Liquidation;
use App\Models\LiquidationData;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ItineraryHead;
use App\Models\AccomplishmentHead;
use App\Models\Receipt;
use App\Models\ReportNotification;

class AgentItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentiindex()
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
        
        return view('agent.itinerary', compact('itinerary', 'user', 'products', 'accounts', 'lastItinerary', 'Itinerary_accomplishment'));
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

    public function agentaindex()
    {
        $user = Auth::user();
        //$itinerary = Itinerary::latest()->paginate(5);
        $accomplishment = AccomplishmentHead::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('agent.accomplishment', compact('accomplishment', 'user'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function agentreceipt(Liquidation $liquidation)
    {
        $user = Auth::user();
        $receipts = Receipt::where('liquidation_id', $liquidation->id)->get();
        return view('agent.receipts', compact('receipts', 'user'));

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
        return view('agent.createitin', compact('accounts', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agentstore(Request $request)
{
    if($request->ajax()){
        try {
            $request->validate([
                'date_from' => 'required',
                'date_to' => 'required',
                'area_id' => 'required',
                'user_id' => 'required',
                'date' => 'required|array',
                'name_of_coop' => 'required|array',
                'municipality' => 'required|array',
                'account_id' => 'required|array',
                'purpose' => 'required|array',
                'product_id' => 'required|array',
            ]);

            $area_id = $request->area_id;
            $user_id = $request->user_id;
            $date = $request->date;
            $name_of_coop = $request->name_of_coop;
            $municipality = $request->municipality;
            $account_id = $request->account_id;
            $purpose = $request->purpose;
            $product_id = $request->product_id;
            $remarks = $request->remarks;
            $status = $request->status;

            $Itin_head = ItineraryHead::create([
                'user_id' => Auth::user()->id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                "status"=>$status,
                "approver_role"=>'',
            ]);

            $allFieldsFilled = true;

            for ($i=0; $i < count($name_of_coop); $i++){
                if(!$date[$i] || !$name_of_coop[$i] || !$municipality[$i] || !$account_id[$i] || !$purpose[$i] || !$product_id[$i]){
                    $allFieldsFilled = false;
                    break;
                }

                $request->merge([
                    'date' => $date[$i],
                    'name_of_coop' => $name_of_coop[$i],
                    'municipality' => $municipality[$i],
                    'account_id' => $account_id[$i],
                    'purpose' => $purpose[$i],
                    'product_id' => $product_id[$i],
                ]);

                $request->validate([
                    'date' => 'required',
                    'name_of_coop' => 'required',
                    'municipality' => 'required',
                    'account_id' => 'required',
                    'purpose' => 'required',
                    'product_id' => 'required',
                ]);

                $datasave = [
                    "itin_head" => $Itin_head->id,
                    "area_id"=>Auth::user()->area_id,
                    "user_id"=>Auth::user()->id,
                    "date"=>$date[$i],
                    "name_of_coop"=>$name_of_coop[$i],
                    "municipality"=>$municipality[$i],
                    "account_id"=>$account_id[$i],
                    "purpose"=>$purpose[$i],
                    "product_id"=>$product_id[$i],
                    "remarks"=>'',
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ];
                $itineraries = DB::table('itineraries')->insert($datasave);
            }

            if ($allFieldsFilled) {
                ReportNotification::create([
                    'user_id' => $Itin_head->user_id,
                    'itinerary_id' => $Itin_head->id,
                    'accomplishment_id' => null,
                    'liquidation_id' => null,
                    'status' => 'unapproved',
                ]);

                session()->flash('already', 'Itineraries Created Successfully.');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'All fields are required.'], 400);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation errors.'], 400);
        }
    }
}

    public function agent_showitinerary(ItineraryHead $itinerary)
    {
        $data = Itinerary::where('itin_head', $itinerary->id)->get();
        return view('agent.itinerarydetails', compact('itinerary', 'data'));
    }

    public function agent_showaccomplishment(AccomplishmentHead $accomplishment)
    {
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        return view('agent.accomplishmentdetails', compact('accomplishment', 'data'));
    }

    public function save(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required',
            'date' => 'nullable',
            'name_of_coop' => 'nullable',
            'municipality' => 'nullable',
            'account_id' => 'nullable',
            'purpose' => 'nullable',
            'product_id' => 'nullable',
            'remarks' => 'nullable',
        ]);

        $id = $validatedData['id'];
        $date = $validatedData['date'];
        $name_of_coop = $validatedData['name_of_coop'];
        $municipality = $validatedData['municipality'];
        $account_id = $validatedData['account_id'];
        $purpose = $validatedData['purpose'];
        $product_id = $validatedData['product_id'];
        $remarks = $validatedData['remarks'] ?? null;

        for ($i = 0; $i < count($name_of_coop); $i++) {
            $accomplishment = Accomplishment::findOrFail($id[$i]);

            if($remarks[$i] == null){
                $accomplishment->remarks = '';
                $accomplishment->save();
            }
            else{
                $accomplishment->remarks = $remarks[$i];
                $accomplishment->save();
            }
        }

        return redirect()->back()->with('success','Accomplishment saved successfully!');
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
    public function iedit(Itinerary $itinerary)
    {
        $products = Product::all();
        $accounts = Account::all();
        return view('agent.edititinerary', compact('itinerary', 'products', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function iupdate(Request $request, Itinerary $itinerary)
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

        $itinerary->update($input);

        //SAMLPE TO CUSTOM INSERT VALUE INTO TABLE
        $itinerary->status = 'Updated';
        $itinerary->save();

        return redirect()->route('agentiindex')->with('success','Itinerary updated successfully!');
    }

    public function accountedit($id){
        $data = Itinerary::find($id);
            $data->status='account edited';
            $data->save();
            return redirect()->back()->with('success','You can now edit the Account field.');
    }

    public function productedit($id){
        $data = Itinerary::find($id);
            $data->status='product edited';
            $data->save();
            return redirect()->back()->with('success','You can now edit the Product field.');
    }

    public function confirmAccomplishment(ItineraryHead $itinerary)
    {
        $data = Itinerary::where('itin_head', $itinerary->id)->get();
        $products = Product::all();
        $accounts = Account::all();
        return view('agent.confirmaccomplishment', compact('itinerary', 'products', 'accounts', 'data'));
    }

    public function createAccomplishment($id, Request $request){

        $input = $request->all();
        $user = Auth::user();
        $data = ItineraryHead::find($id);
        

        $accomplishment_head = AccomplishmentHead::create([
            'itin_head' => $data->id,
            'user_id' => Auth::user()->id,
            'date_from' => $data->date_from,
            'date_to' => $data->date_to,
            "status"=>'Pending',
            "approver_role"=>'',
        ]);

        for ($i=0; $i < count($request->name_of_coop); $i++){

            $datasave = [
                "itin_head" => $data->id,
                "accomplishment_head" => $accomplishment_head->id,
                "area_id"=> $user->area_id,
                "user_id"=> $user->id,
                "date"=>$request->date[$i],
                "name_of_coop"=>$request->name_of_coop[$i],
                "municipality"=>$request->municipality[$i],
                "account_id"=>$request->account_id[$i],
                "purpose"=>$request->purpose[$i],
                "product_id"=>$request->product_id[$i],
                "remarks"=> $request->remarks[$i] ?? '',
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            

            ];
            $itineraries = DB::table('accomplishments')->insert($datasave);
        }

        $data->status = 'Accomplishment Created';
        $data->save();
        
        return redirect()->route('agentiindex')->with('success','Accomplishment created successfully!');

    }

    public function safilter(Request $request){
        $user = Auth::user();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $products = Product::all();
        $accounts = Account::all();

        $itinerary = ItineraryHead::where('user_id',$user->id)
        ->where('date_from', '>=', $start_date)
        ->where('date_from', '<=', $end_date)
        ->orderBy('created_at','desc')
        ->get();

        $lastItinerary = ItineraryHead::where('user_id', $user->id)->latest()->first();

        if($lastItinerary){
            $Itinerary_accomplishment = AccomplishmentHead::where('itin_head',  $lastItinerary->id)->first(); 
        }
        else{
            $Itinerary_accomplishment= '';
        }

        return view('agent.itinerary', compact('itinerary', 'user', 'products', 'accounts', 'lastItinerary', 'Itinerary_accomplishment'));
    }

    public function safilter2(Request $request){
        $user = Auth::user();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $accomplishment = AccomplishmentHead::where('user_id',$user->id)
        ->where('date_from', '>=', $start_date)
        ->where('date_from', '<=', $end_date)
        ->orderBy('created_at','desc')
        ->get();

        return view('agent.accomplishment', compact('accomplishment', 'user'));
    }

    public function agentlindexshow()
    {
        $user = Auth::user();
        //$itinerary = Itinerary::latest()->paginate(5);
        $liquidations = Liquidation::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('agent.showliquidation', compact('liquidations'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function saagentlindex()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        //$itinerary = Itinerary::latest()->paginate(5);
        $accomplishment = Accomplishment::where('user_id',$user->id)->orderBy('date','desc')->get();
        return view('agent.liquidation', compact('accomplishment', 'user', 'products', 'accounts'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function saliquidationstore(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'activity' => 'required',
        'employee_name' => 'required',
        'position' => 'required',
        'date_filed' => 'required',
        'inclusive_date' => 'required',
    ]);

    $newL = Liquidation::create([
        'user_id' => Auth::user()->id,
        'activity' => $request->activity,
        'employee_name' => $request->employee_name,
        'position' => $request->position,
        'date_filed' => $request->date_filed,
        'inclusive_date' => $request->inclusive_date,
        'status' => 'Pending',
        'liquidated_by' => Auth::user()->id,
    ]);

    $validatedData = $request->validate([
        'user_id' => 'nullable',
        'liquidation_id' => 'nullable',
        'date' => 'nullable',
        'travel_itinerary_from' => 'nullable',
        'travel_itinerary_to' => 'nullable',
        'reference' => 'nullable',
        'particulars' => 'nullable',
        'transpo' => 'nullable',
        'hotel' => 'nullable',
        'meals' => 'nullable',
        'sundry' => 'nullable',
        'amount' => 'nullable',
        'cash_advance' => 'nullable',
    ]);

    $date = $validatedData['date'];
    $travel_itinerary_from = $validatedData['travel_itinerary_from'];
    $travel_itinerary_to = $validatedData['travel_itinerary_to'];
    $reference = $validatedData['reference'];
    $particulars = $validatedData['particulars'];
    $sundry = $validatedData['sundry'];
    $cash_advance = $validatedData['cash_advance'] ?? 0;
    $total = 0; // Initialize the total variable

    $liquidationDataIds = [];

    for ($i = 0; $i < count($particulars); $i++) {
        $transpo = $validatedData['transpo'][$i] ?? 0;
        $hotel = $validatedData['hotel'][$i] ?? 0;
        $meals = $validatedData['meals'][$i] ?? 0;
        $amount = $validatedData['amount'][$i] ?? 0;

        $row_total = $transpo + $hotel + $meals + $amount;

        $total += $row_total; // Add the row total to the total variable

        $liquidationDataId = DB::table('liquidation_data')->insertGetId([
            'user_id' => Auth::user()->id,
            'liquidation_id' => $newL->id,
            "date" => $date[$i] ?? null,
            "travel_itinerary_from" => $travel_itinerary_from[$i] ?? '',
            "travel_itinerary_to" => $travel_itinerary_to[$i] ?? '',
            "reference" => $reference[$i] ?? '',
            "particulars" => $particulars[$i] ?? '',
            "transpo" => $transpo,
            "hotel" => $hotel,
            "meals" => $meals,
            "sundry" => $sundry[$i] ?? '',
            "amount" => $amount,
            'cash_advance' => $cash_advance,
            'for_or' => $request->for_or[$i] ?? 0,
            "row_total" => $row_total,
            'total' => $total,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $liquidationDataIds[] = $liquidationDataId; 
       // DB::table('liquidation_data')->insert($datasave);
    }

    // Update the total column of each row with the total sum of all row totals
    DB::table('liquidation_data')
        ->where('created_at', Carbon::now())
        ->update(['total' => $total]);

    $message = [
        'required' => 'Please attach your receipt.'
    ];

    $this->validate($request, [
        'receipt' => 'required',
    ], $message);

    foreach($request->receipt as $receipt){
        $filename = time() . '_' . $receipt->getClientOriginalName();
        $filesize = $receipt->getSize();
        $receipt->storeAs('public/',$filename);
        $receiptModel = new Receipt;
        $receiptModel->liquidation_id = $newL->id;
        $receiptModel->name = $filename;
        $receiptModel->size = $filesize;
        $receiptModel->location = 'storage/'.$filename;
        $receiptModel->save();
    }

    return redirect()->route('sashowliquidation', $newL->id)->with('success', 'Liquidation Created Succesfully');
    }

    public function sashowliquidation(Liquidation $liquidation)
    {
        $data = LiquidationData::where('liquidation_id', $liquidation->id)->get();
        return view('agent.liquidationdetails', compact('liquidation', 'data'));
    }

    public function downloadpreview($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('liquidation_id', $liquidation->id)->get();
        $date = Carbon::now();
        $year = $date->year;

        return view('agent.download.liquidation', compact('liquidation', 'data', 'year'));
    }

    public function downloadliquidation($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('liquidation_id', $liquidation->id)->get();
        $date = Carbon::now();
        $year = $date->year;
        $info = [
            'liquidation' => $liquidation,
            'data' => $data,
            'year' => $year
        ];

        $pdf = Pdf::loadView('agent.download.liquidation', $info);
        return $pdf->download('testliquidation.pdf');
    }

    public function adownloadpreview($id){
        $accomplishment = AccomplishmentHead::findOrFail($id);
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        $date = Carbon::now();
        //$year = $date->year;
        $user = auth()->user();

        $nextitinerary = ItineraryHead::where('user_id', $user->id)
            ->where('id', '>', $accomplishment->itin_head)
            ->where('status', '!=', 'Disapproved')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($nextitinerary){
            $fornext5days = Itinerary::where('itin_head',  $nextitinerary->id)->get();
        }
        else{
            $fornext5days = 0;
        }

        return view('agent.download.accomplishment', compact('accomplishment', 'data', 'date', 'nextitinerary', 'fornext5days'));
    }

    public function downloadaccomplishment($id){
        $accomplishment = AccomplishmentHead::findOrFail($id);
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        $date = Carbon::now();
        //$year = $date->year;
        $user = auth()->user();

        $nextitinerary = ItineraryHead::where('user_id', $user->id)
            ->where('id', '>', $accomplishment->itin_head)
            ->where('status', '!=', 'Disapproved')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($nextitinerary){
            $fornext5days = Itinerary::where('itin_head',  $nextitinerary->id)->get();
        }
        else{
            $fornext5days = 0;
        }

        $info = [
            'accomplishment' => $accomplishment,
            'data' => $data,
            'date' => $date,
            'fornext5days' => $fornext5days
        ];

        $pdf = Pdf::loadView('agent.download.accomplishment', $info);
        return $pdf->download('testaccomplishment.pdf');
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
