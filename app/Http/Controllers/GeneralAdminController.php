<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Accomplishment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Product;
use App\Models\AreaOfAssignment;
use App\Models\Liquidation;
use App\Models\LiquidationData;
use App\Models\ItineraryHead;
use App\Models\AccomplishmentHead;
use App\Models\Receipt;
use App\Models\ReportNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\CSRF;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneralAdminController extends Controller
{
    public $row_total = 0, $total = 0;

    public function adminiindex()
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
        return view('admin.itinerary', compact('itinerary', 'user', 'accounts','products', 'lastItinerary', 'Itinerary_accomplishment'));
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

    public function adminishowuser()
    {

        $role_id = 0;

        $agent = User::all();

        return view('admin.viewitinerary', compact('agent','role_id'));

    }

    public function adminashowuser()
    {

        $role_id = 0;

        $agent = User::all();

        return view('admin.viewaccomplishment', compact('agent'));

    }

    public function adminlshowuser()
    {

        $role_id = 0;

        $agent = User::all();

        return view('admin.viewliquidation', compact('agent'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminuserreports($id)
    {
        $user = User::findOrFail($id);
        $itinerary = $user->itinerary_heads()->orderBy('created_at', 'desc')->get();  // the "itineraries" is called and defined inside Itinerary Mdel

        return view('admin.userreports.itinerary', compact('itinerary', 'user'));
    }

    public function adminuserreports2($id)
    {
        $user = User::findOrFail($id);
        $accomplishment = $user->accomplishment_heads()->orderBy('created_at', 'desc')->get();  // the "accomplishments" is called and defined inside Accomplishment Mdel

        return view('admin.userreports.accomplishment', compact('accomplishment', 'user'));
    }

    public function adminuserreports3($id)
    {
        $user = User::findOrFail($id);
        $liquidations = $user->liquidations()->orderBy('created_at', 'desc')->get();  // the "accomplishments" is called and defined inside Accomplishment Mdel

        return view('admin.userreports.liquidation', compact('liquidations', 'user'));
    }

    public function nsmaccountedit($id){
        $data = Itinerary::find($id);
            $data->status='account edited';
            $data->save();
            return redirect()->back()->with('success','You can now edit the Account field.');
    }

    public function nsmproductedit($id){
        $data = Itinerary::find($id);
            $data->status='product edited';
            $data->save();
            return redirect()->back()->with('success','You can now edit the Product field.');
    }

    public function adminapprove($id)
    {
        $user = Auth::user();
        $data = ItineraryHead::find($id);
        if ($data->status !== 'Accomplishment Created'){
            $data->status='Approved';
            $data->approved_by=Auth::user()->id;
            $data->approver_role=Auth::user()->role;
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Itinerary approved succesfully.');
        }
        else{
            return redirect()->back()->with('already', 'Itinerary is already approved.');
        }
    }

    public function admindisapprove($id)
    {
        $data = ItineraryHead::find($id);
        if ($data->status !== 'Accomplishment Created'){
            $data->status='Disapproved';
            $data->approved_by=null;
            $data->approver_role='';
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Itinerary disapproved.');
        }
        else{
            return redirect()->back()->with('already', 'Itinerary is already approved.');
        }
    }

    public function adminapprove2($id)
    {
        $user = Auth::user();
        $data = AccomplishmentHead::find($id);
        if ($data->status !== 'Approved'){
            $data->status='Approved';
            $data->approved_by=Auth::user()->id;
            $data->approver_role=Auth::user()->role;
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment approved succesfully.');
        }
        else{
            return redirect()->back()->with('already', 'Accomplishment is already approved.');
        }

        /*
        $user = Auth::user();
        $data = Accomplishment::find($id);
        if ($data->status === 'Accomplishment Created'){
            $data->status='Approved Accomplishment';
            $data->approved_by=$user->id;
            $data->approver_role=$user->role;
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment approved succesfully.');
        }
        elseif ($data->status === 'Disapproved Accomplishment'){
            $data->status='Approved Accomplishment';
            $data->approved_by=$user->id;
            $data->approver_role=$user->role;
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment approved succesfully.');
        }
        else{
            return redirect()->back()->with('already', 'Accomplishment approved already.');
        }
        */
        
    }

    public function admindisapprove2($id)
    {
        $data = AccomplishmentHead::find($id);
        if ($data->status !== 'Approved'){
            $data->status='Disapproved';
            $data->approved_by=null;
            $data->approver_role='';
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment disapproved.');
        }
        else{
            return redirect()->back()->with('already', 'Accomplishment is already approved.');
        }

        /*
        $data = Accomplishment::find($id);

        if ($data->status === 'Accomplishment Created'){
            $data->status='Disapproved Accomplishment';
            $data->approved_by=null;
            $data->approver_role='';
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment disapproved.');
        }
        elseif ($data->status === 'Approved Accomplishment'){
            $data->status='Disapproved Accomplishment';
            $data->approved_by=null;
            $data->approver_role='';
            $data->save();
            return redirect()->back()->with('success', 'Accomplishment disapproved.');
        }
        else{
            return redirect()->back()->with('already', 'Accomplishment disapproved already.');
        }
        */
    }

    public function adminapprove3($id)
    {
        $user = Auth::user();
        $data = Liquidation::find($id);
        if ($data->status !== 'Approved'){
            $data->status='Approved';
            $data->recommending_approval=Auth::user()->id;
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Liquidation approved succesfully.');
        }
        else{
            return redirect()->back()->with('already', 'Liquidation is already approved.');
        }
    }

    public function admindisapprove3($id)
    {
        $data = Liquidation::find($id);
        if ($data->status !== 'Approved'){
            $data->status='Disapproved';
            $data->recommending_approval=null;
            $carbon = Carbon::now()->setTimezone('Asia/Manila');
            $data->updated_at = $carbon;
            $data->save();
            return redirect()->back()->with('success', 'Liquidation disapproved.');
        }
        else{
            return redirect()->back()->with('already', 'Liquidation is already approved.');
        }
    }

    public function adminaction(Request $request){
        
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('users')
                ->where('role', 0)
                ->where(function($query) use ($request){
                    $query->where('firstname', 'like', '%' .$request->get('query').'%')
                    ->orWhere('lastname', 'like', '%'.$request->get('query').'%');
                })
                ->orderBy('id','desc')
                ->get();
            }
            else{
                $data = DB::table('users')->where('role', '!=', 6)->orderBy('id','desc')->get();   
            }
    
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '
                    <tr>
                        <td>'.$row->firstname.'</td>
                        <td>'.$row->lastname.'</td>
                        <td>'.$row->email.'</td>
                        <td>
                            <form action="'.url('/admin/reports', $row->id).'" method="GET">
                                <button class="btn btn-info" type="submit">Reports</button>
                            </form>
                        </td>
                    </tr>
                    ';
                }
            }
            else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No User Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }

    public function adminaction2(Request $request){
        
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('users')
                ->where('role', 0)
                ->where(function($query) use ($request){
                    $query->where('firstname', 'like', '%' .$request->get('query').'%')
                    ->orWhere('lastname', 'like', '%'.$request->get('query').'%');
                })
                ->orderBy('id','desc')
                ->get();
            }
            else{
                $data = DB::table('users')->where('role', '!=', 6)->orderBy('id','desc')->get();   
            }
    
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '
                    <tr>
                        <td>'.$row->firstname.'</td>
                        <td>'.$row->lastname.'</td>
                        <td>'.$row->email.'</td>
                        <td>
                            <form action="'.url('/admin/accomplishment/reports', $row->id).'" method="GET">
                                <button class="btn btn-info" type="submit">Reports</button>
                            </form>
                        </td>
                    </tr>
                    ';
                }
            }
            else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No User Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }

    public function adminaction3(Request $request){
        
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('users')
                ->where('role', 0)
                ->where(function($query) use ($request){
                    $query->where('firstname', 'like', '%' .$request->get('query').'%')
                    ->orWhere('lastname', 'like', '%'.$request->get('query').'%');
                })
                ->orderBy('id','desc')
                ->get();
            }
            else{
                $data = DB::table('users')->where('role', '!=', 6)->orderBy('id','desc')->get();   
            }
    
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '
                    <tr>
                        <td>'.$row->firstname.'</td>
                        <td>'.$row->lastname.'</td>
                        <td>'.$row->email.'</td>
                        <td>
                            <form action="'.url('/admin/liquidation/reports', $row->id).'" method="GET">
                                <button class="btn btn-info" type="submit">Reports</button>
                            </form>
                        </td>
                    </tr>
                    ';
                }
            }
            else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No User Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function adminstore(Request $request)
{
    if($request->ajax()){
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

    
    $request->validate([
        'date_from' => 'required',
        'date_to' => 'required',
    ]);

    $Itin_head = ItineraryHead::create([
        'user_id' => Auth::user()->id,
        'date_from' => $request->date_from,
        'date_to' => $request->date_to,
        "status"=>'Pending',
        "approver_role"=>'',
    ]);
    

    if( $request->date !== null){
    

        for ($i=0; $i < count($name_of_coop); $i++){
            if(empty($name_of_coop[$i]) || empty($municipality[$i]) || empty($account_id[$i]) || empty($purpose[$i]) || empty($product_id[$i])){
                return response()->json(['error' => 'All fields are required.'], 400);
            }

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
    
        session()->flash('already', 'Itineraries Created Successfully.');

        return response()->json(['success' => true]);
    }
    else{
        return response()->json(['error' => session('error')], 400);
    }
    }
    }

    public function nsmiedit(Itinerary $itinerary)
    {
        $products = Product::all();
        $accounts = Account::all();
        return view('nsmnonlife.edititinerary', compact('itinerary', 'products', 'accounts'));
    }

    public function nsmiupdate(Request $request, Itinerary $itinerary)
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

        return redirect()->route('iindex')->with('success','Itinerary updated successfully!');
    }

    public function adminconfirmAccomplishment(ItineraryHead $itinerary)
    {
        $data = Itinerary::where('itin_head', $itinerary->id)->get();
        $products = Product::all();
        $accounts = Account::all();
        return view('admin.confirmaccomplishment', compact('itinerary', 'products', 'accounts', 'data'));
    }

    public function admincreateAccomplishment($id, Request $request){

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
        
        return redirect()->route('adminiindex')->with('success','Accomplishment created successfully!');

    }

    public function adminagentaindex()
    {
        $user = Auth::user();
        //$itinerary = Itinerary::latest()->paginate(5);
        $accomplishment = AccomplishmentHead::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('admin.accomplishment', compact('accomplishment', 'user'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function adminagentlindex()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        //$itinerary = Itinerary::latest()->paginate(5);
        $accomplishment = Accomplishment::where('user_id',$user->id)->orderBy('date','desc')->get();
        return view('admin.liquidation', compact('accomplishment', 'user', 'products', 'accounts'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function adminagentlindexshow()
    {
        $user = Auth::user();
        //$itinerary = Itinerary::latest()->paginate(5);
        $liquidations = Liquidation::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('admin.showliquidation', compact('liquidations'));
        //return view('itinerary', compact('itinerary'))->with('i',(request()->input('page',1)-1)*5);

    }

    public function approveAll(Request $request){
        $user = Auth::user();
        $ids = $request->ids;
        Itinerary::whereIn('id', $ids)->update(['status' => 'Approved', 'approved_by' => $user->id, 'approver_role' => $user->role]);
        return response()->json(['url' => url()->previous()]);
    }

    public function approveAll2(Request $request){
        $user = Auth::user();
        $ids = $request->ids;
        Accomplishment::whereIn('id', $ids)->update(['status' => 'Approved Accomplishment', 'approved_by' => $user->id, 'approver_role' => $user->role]);
        return response()->json(['url' => url()->previous()]);
    }

    public function approveAll3(Request $request){
        $user = Auth::user();
        $ids = $request->ids;
        Liquidation::whereIn('id', $ids)->update(['status' => 'Approved', 'recommending_approval' => $user->id,]);
        return response()->json(['url' => url()->previous()]);
    }

    public function adminfilter(Request $request, $id){
        $user = User::findOrFail($id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $itinerary = $user->itinerary_heads()
        ->where('date_from', '>=', $start_date)
        ->where('date_from', '<=', $end_date)
        ->orderBy('created_at','desc')
        ->get();

        return view('admin.userreports.itinerary', compact('itinerary', 'user'));
    }

    public function adminfilter2(Request $request, $id){
        $user = User::findOrFail($id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $accomplishment = $user->accomplishment_heads()
        ->where('date_from', '>=', $start_date)
        ->where('date_from', '<=', $end_date)
        ->orderBy('created_at','desc')
        ->get();

        return view('admin.userreports.accomplishment', compact('accomplishment', 'user'));
    }

    public function adminfilter3(Request $request, $id){
        $user = User::findOrFail($id);
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $liquidations = $user->liquidations()
        ->where('date_filed', '>=', $start_date)
        ->where('date_filed', '<=', $end_date)
        ->orderBy('created_at','desc')
        ->get();

        return view('admin.userreports.liquidation', compact('liquidations', 'user'));
    }

    public function adminliquidationstore(Request $request)
{
    $message = [
        'required' => 'Please attach your receipt.'
    ];

    $request->validate([
        'user_id' => 'required',
        'activity' => 'required',
        'employee_name' => 'required',
        'position' => 'required',
        'date_filed' => 'required',
        'inclusive_date' => 'required',
        'receipt' => 'required',
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

    return redirect()->route('adminshowliquidation', $newL->id)->with('success', 'Liquidation Created Succesfully');
    }

    public function adminshowliquidation(Liquidation $liquidation)
    {
        $data = LiquidationData::where('liquidation_id', $liquidation->id)->get();
        return view('admin.liquidationdetails', compact('liquidation', 'data'));
    }

    public function admindownloadpreview($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('created_at', $liquidation->created_at)->get();
        $date = Carbon::now();
        $year = $date->year;

        return view('admin.download.liquidation', compact('liquidation', 'data', 'year'));
    }

    public function admindownloadliquidation($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('created_at', $liquidation->created_at)->get();
        $date = Carbon::now();
        $year = $date->year;
        $info = [
            'liquidation' => $liquidation,
            'data' => $data,
            'year' => $year
        ];

        $pdf = Pdf::loadView('admin.download.liquidation', $info);
        return $pdf->download('liquidation #'.$liquidation->id.' - '.Auth::user()->firstname.'.pdf');
    }

    public function adminshowagentliquidation(Liquidation $liquidation)
    {
        $data = LiquidationData::where('liquidation_id', $liquidation->id)->get();
        return view('admin.userreports.liquidationdetails', compact('liquidation', 'data'));
    }

    public function adminagentdownloadpreview($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('created_at', $liquidation->created_at)->get();
        $date = Carbon::now();
        $year = $date->year;

        return view('admin.download.userreport.liquidation', compact('liquidation', 'data', 'year'));
    }

    public function adminagentdownloadliquidation($id){
        $liquidation = Liquidation::findOrFail($id);
        $data = LiquidationData::where('created_at', $liquidation->created_at)->get();
        $date = Carbon::now();
        $year = $date->year;
        $info = [
            'liquidation' => $liquidation,
            'data' => $data,
            'year' => $year
        ];

        $pdf = Pdf::loadView('admin.download.userreport.liquidation', $info);
        return $pdf->download('liquidation #'.$liquidation->id.' - '.Auth::user()->firstname.'.pdf');
    }

    public function adminshowitinerary(ItineraryHead $itinerary)
    {
        $data = Itinerary::where('itin_head', $itinerary->id)->get();
        return view('admin.itinerarydetails', compact('itinerary', 'data'));
    }

    public function admin_showaccomplishment(AccomplishmentHead $accomplishment)
    {
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        return view('admin.accomplishmentdetails', compact('accomplishment', 'data'));
    }

    public function admin_agent_showitinerarydetails(ItineraryHead $itinerary)
    {
        $reportget = ReportNotification::where('itinerary_id',$itinerary->id)->first();
        $report = ReportNotification::find($reportget->id);
        $report->status = 'viewed';
        $report->save();
        $data = Itinerary::where('itin_head', $itinerary->id)->where('user_id', $itinerary->user_id)->get();
        return view('admin.userreports.itinerarydetails', compact('itinerary', 'data'));
    }

    public function admin_agent_showaccomplishmentdetails(AccomplishmentHead $accomplishment)
    {
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->where('user_id', $accomplishment->user_id)->get();
        return view('admin.userreports.accomplishmentdetails', compact('accomplishment', 'data'));
    }

    public function admin_save(Request $request)
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

    public function adminreceipt(Liquidation $liquidation)
    {
        $user = Auth::user();
        $receipts = Receipt::where('liquidation_id', $liquidation->id)->get();
        return view('admin.receipts', compact('receipts', 'user'));

    }

    public function adminagentliquidationreceipt(Liquidation $liquidation)
    {
        $user = User::findOrFail($liquidation->user_id);
        $receipts = Receipt::where('liquidation_id', $liquidation->id)->get();
        return view('admin.receipts', compact('receipts', 'user'));

    }

    public function adminadownloadpreview($id){
        $accomplishment = AccomplishmentHead::findOrFail($id);
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        $date = Carbon::now();
        //$year = $date->year;
        //$user = $accomplishment->user_id;

        $nextitinerary = ItineraryHead::where('user_id', $accomplishment->user_id)
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

        return view('admin.download.userreport.accomplishment', compact('accomplishment', 'data', 'date', 'nextitinerary', 'fornext5days'));
    }

    public function admindownloadaccomplishment($id){
        $accomplishment = AccomplishmentHead::findOrFail($id);
        $data = Accomplishment::where('accomplishment_head', $accomplishment->id)->get();
        $date = Carbon::now();
        //$year = $date->year;
        $user = $accomplishment->user_id;

        $nextitinerary = ItineraryHead::where('user_id', $accomplishment->user_id)
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

        $pdf = Pdf::loadView('admin.download.userreport.accomplishment', $info);
        return $pdf->download('testaccomplishment.pdf');
    }

    public function adminmyadownloadpreview($id){
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

        return view('admin.download.accomplishment', compact('accomplishment', 'data', 'date', 'nextitinerary', 'fornext5days'));
    }

    public function adminmydownloadaccomplishment($id){
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

        $pdf = Pdf::loadView('admin.download.accomplishment', $info);
        return $pdf->download('testaccomplishment.pdf');
    }


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
