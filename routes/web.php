<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\Agent\AgentItineraryController;
use App\Http\Controllers\LiquidationController;
use App\Http\Controllers\UserItineraryReportsController;
use App\Http\Controllers\GeneralAdminController;
use App\Http\Controllers\Auth\RegisteredUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
Route::get('{any}', function () {
    return view('app');
})->where('any','.*');
*/

//test view records
//Route::get("/itineraries",[ItineraryController::class,'iindex'])->name('iindex');

/*
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

//SA,BDS,GAMS route
Route::middleware(['auth','user-role:agents'])->group(function(){
    Route::get("/home",[HomeController::class,'agentHome'])->name('home');
    Route::get("/sa/itineraries",[AgentItineraryController::class,'agentiindex'])->name('agentiindex');
    Route::get("/sa/create/itineraries",[AgentItineraryController::class,'icreate'])->name('icreate');
    Route::post("/sa/store/itineraries",[AgentItineraryController::class,'agentstore'])->name('agentstore');
    Route::get("/sa/edit/{itinerary}",[AgentItineraryController::class,'iedit'])->name('iedit');
    Route::put("/sa/edit/{itinerary}",[AgentItineraryController::class,'iupdate'])->name('iupdate');
    Route::get("/sa/accomplishments",[AgentItineraryController::class,'agentaindex'])->name('agentaindex');
    Route::get("/sa/create/accomplishment/{itinerary}",[AgentItineraryController::class,'confirmAccomplishment'])->name('confirmAccomplishment');
    Route::post("/sa/create/accomplishment/{itinerary}",[AgentItineraryController::class,'createAccomplishment'])->name('createAccomplishment');
    Route::get('/itineraries/find', [AgentItineraryController::class, 'safilter'])->name('safilter');
    Route::get('/accomplishment/find', [AgentItineraryController::class, 'safilter2'])->name('safilter2');
    Route::get("/sa/liquidations",[AgentItineraryController::class,'agentlindexshow'])->name('agentlindexshow');
    Route::get("/sa/create/liquidation",[AgentItineraryController::class,'saagentlindex'])->name('saagentlindex');
    Route::post("/sa/create/liquidation",[AgentItineraryController::class,'saliquidationstore'])->name('saliquidationstore');
    Route::get("/sa/show/{liquidation}",[AgentItineraryController::class,'sashowliquidation'])->name('sashowliquidation');
    Route::get("/sa/preview/{liquidation}",[AgentItineraryController::class,'downloadpreview'])->name('downloadpreview');
    Route::get("/sa/download/{liquidation}",[AgentItineraryController::class,'downloadliquidation'])->name('downloadliquidation');
    Route::get("/sa/show/details/{itinerary}",[AgentItineraryController::class,'agent_showitinerary'])->name('agent_showitinerary');
    Route::get("/sa/accomplishment/details/{accomplishment}",[AgentItineraryController::class,'agent_showaccomplishment'])->name('agent_showaccomplishment');
    Route::post("/sa/save/accomplishment",[AgentItineraryController::class,'save'])->name('save');
    Route::get("/sa/receipts/{liquidation}",[AgentItineraryController::class,'agentreceipt'])->name('agentreceipt');
    Route::get("/sa/accomplishment-preview/{liquidation}",[AgentItineraryController::class,'adownloadpreview'])->name('adownloadpreview');
    Route::get("/sa/accomplishment-download/{liquidation}",[AgentItineraryController::class,'downloadaccomplishment'])->name('downloadaccomplishment');
    
    /*
    Route::get("/liquidations",[LiquidationController::class,'lindex'])->name('lindex');
    Route::get("/create/liquidations",[LiquidationController::class,'lcreate'])->name('lcreate');
    Route::post("/store/liquidation",[LiquidationController::class,'lstore'])->name('lstore');
    Route::get("/show/{liquidation}",[LiquidationController::class,'show'])->name('show');
    Route::get("/edit/{liquidation}",[LiquidationController::class,'edit'])->name('edit');
    Route::put("/edit/{liquidation}",[LiquidationController::class,'update'])->name('update');
    */
    Route::get('/accountedit/{id}', [AgentItineraryController::class, 'accountedit']);
    Route::get('/productedit/{id}', [AgentItineraryController::class, 'productedit']);
    //Route::get("/cashadvance/{liquidation}",[LiquidationController::class,'ca'])->name('ca');
    //Route::put("/cashadvance/{liquidation}",[LiquidationController::class,'cca'])->name('cca');
});

//RSM route
Route::middleware(['auth','user-role:rsm'])->group(function(){
    Route::get("/rsm/home",[HomeController::class,'rsmHome'])->name('home.rsm');
});

//ASM route
Route::middleware(['auth','user-role:asm'])->group(function(){
    Route::get("/asm/home",[HomeController::class,'asmHome'])->name('home.asm');
});

//NSM non-life route
Route::middleware(['auth','user-role:nsm_nl'])->group(function(){
    Route::get("/nsmnl/home",[HomeController::class,'nsmnlHome'])->name('home.nsmnl');
    Route::get("/itineraries",[ItineraryController::class,'iindex'])->name('iindex');
    Route::get("/create/itineraries",[ItineraryController::class,'icreate'])->name('icreate');
    Route::post("/store/itineraries",[UserItineraryReportsController::class,'store'])->name('store');
    //Route::post("/store2/itineraries",[UserItineraryReportsController::class,'store2'])->name('store2');
    Route::get("/itinerary/reports",[UserItineraryReportsController::class,'ishowuser'])->name('ishowuser');
    Route::get("/accomplishment/reports",[UserItineraryReportsController::class,'ashowuser'])->name('ashowuser');
    Route::get("/liquidation/reports",[UserItineraryReportsController::class,'lshowuser'])->name('ashowuser');
    Route::get('/reports/{id}', [UserItineraryReportsController::class, 'userreports']);
    Route::get('/accomplishment/reports/{id}', [UserItineraryReportsController::class, 'userreports2']);
    Route::get('/liquidation/reports/{id}', [UserItineraryReportsController::class, 'userreports3']);
    Route::get('/approve/itinerary/{id}', [UserItineraryReportsController::class, 'approve'])->name('approve');
    Route::get('/disapprove/itinerary/{id}', [UserItineraryReportsController::class, 'disapprove'])->name('disapprove');
    Route::get('/approve/accomplishment/{id}', [UserItineraryReportsController::class, 'approve2'])->name('approve2');
    Route::get('/disapprove/accomplishment/{id}', [UserItineraryReportsController::class, 'disapprove2'])->name('disapprove2');
    Route::get('/approve/liquidation/{id}', [UserItineraryReportsController::class, 'approve3'])->name('approve3');
    Route::get('/disapprove/liquidation/{id}', [UserItineraryReportsController::class, 'disapprove3'])->name('disapprove3');
    Route::get("/action",[UserItineraryReportsController::class,'action'])->name('action');
    Route::get("/action2",[UserItineraryReportsController::class,'action2'])->name('action2');
    Route::get("/action3",[UserItineraryReportsController::class,'action3'])->name('action3');
    Route::get("/nsm/edit/{itinerary}",[UserItineraryReportsController::class,'nsmiedit'])->name('nsmiedit');
    Route::put("/nsm/edit/{itinerary}",[UserItineraryReportsController::class,'nsmiupdate'])->name('nsmiupdate');
    Route::get("/nsm/create/accomplishment/{itinerary}",[UserItineraryReportsController::class,'nsmconfirmAccomplishment'])->name('nsmconfirmAccomplishment');
    Route::post("/nsm/create/accomplishment/{itinerary}",[UserItineraryReportsController::class,'nsmcreateAccomplishment'])->name('nsmcreateAccomplishment');
    Route::get("/accomplishments",[UserItineraryReportsController::class,'nsmagentaindex'])->name('nsmagentaindex');
    Route::post('/selected-itinerary', [UserItineraryReportsController::class, 'approveAll'])->name('itinerary.approve');
    Route::post('/selected-accomplishment', [UserItineraryReportsController::class, 'approveAll2'])->name('accomplishment.approve');
    Route::post('/selected-liquidation', [UserItineraryReportsController::class, 'approveAll3'])->name('liquidation.approve');
    Route::get('/nsmnl/accountedit/{id}', [UserItineraryReportsController::class, 'nsmaccountedit']);
    Route::get('/nsmnl/productedit/{id}', [UserItineraryReportsController::class, 'nsmproductedit']);
    Route::get('/itineraries/find/{id}', [UserItineraryReportsController::class, 'filter'])->name('filter');
    Route::get('/accomplishment/find/{id}', [UserItineraryReportsController::class, 'filter2'])->name('filter2');
    Route::get('/liquidation/find/{id}', [UserItineraryReportsController::class, 'filter3'])->name('filter3');
    Route::get("/liquidations",[UserItineraryReportsController::class,'nsmagentlindexshow'])->name('nsmagentlindexshow');
    Route::get("/create/liquidation",[UserItineraryReportsController::class,'nsmagentlindex'])->name('nsmagentlindex');
    Route::post("/store/liquidation",[UserItineraryReportsController::class,'liquidationstore'])->name('liquidationstore');
    Route::get("/show/{liquidation}",[UserItineraryReportsController::class,'nsmshowliquidation'])->name('nsmshowliquidation');
    Route::get("/show/agent/{liquidation}",[UserItineraryReportsController::class,'nsmshowagentliquidation'])->name('nsmshowagentliquidation');
    Route::get("/nsm-nonlife/preview/{liquidation}",[UserItineraryReportsController::class,'nsmdownloadpreview'])->name('nsmdownloadpreview');
    Route::get("/nsm-nonlife/download/{liquidation}",[UserItineraryReportsController::class,'nsmdownloadliquidation'])->name('nsmdownloadliquidation');
    Route::get("/nsm-nonlife/agent-preview/{liquidation}",[UserItineraryReportsController::class,'nsmagentdownloadpreview'])->name('nsmagentdownloadpreview');
    Route::get("/nsm-nonlife/agent-download/{liquidation}",[UserItineraryReportsController::class,'nsmagentdownloadliquidation'])->name('nsmagentdownloadliquidation');
    Route::get("/nsm-show/{itinerary}",[UserItineraryReportsController::class,'nsmshowitinerary'])->name('nsmshowitinerary');
    Route::get("/show/report/agent/{itinerary}-details",[UserItineraryReportsController::class,'agent_showitinerarydetails'])->name('agent_showitinerarydetails');
    Route::get("/show/accomplishment/report/agent/{accomplishment}-details",[UserItineraryReportsController::class,'agent_showaccomplishmentdetails'])->name('agent_showaccomplishmentdetails');
    Route::get("/nsm-show/accomplishment/{accomplishment}",[UserItineraryReportsController::class,'nsmnl_showaccomplishment'])->name('nsmnl_showaccomplishment');
    Route::post("/nsm-nonlife/save/accomplishment",[UserItineraryReportsController::class,'nsmnl_save'])->name('nsmnl_save');
    Route::get("/nsm-nonlife/my-receipts/{liquidation}",[UserItineraryReportsController::class,'nsmnlreceipt'])->name('nsmnlreceipt');
    Route::get("/nsm-nonlife/agent-receipts/{liquidation}",[UserItineraryReportsController::class,'agentliquidationreceipt'])->name('agentliquidationreceipt');
    Route::get("/nsm-nonlife/agent/accomplishment-preview/{liquidation}",[UserItineraryReportsController::class,'nsmadownloadpreview'])->name('nsmadownloadpreview');
    Route::get("/nsm-nonlife/agent/accomplishment-download/{liquidation}",[UserItineraryReportsController::class,'nsmdownloadaccomplishment'])->name('nsmdownloadaccomplishment');
    Route::get("/nsm-nonlife/my-accomplishment-preview/{liquidation}",[UserItineraryReportsController::class,'nsmmyadownloadpreview'])->name('nsmmyadownloadpreview');
    Route::get("/nsm-nonlife/my-accomplishment-download/{liquidation}",[UserItineraryReportsController::class,'nsmmydownloadaccomplishment'])->name('nsmmydownloadaccomplishment');
    
});

//NSM for-life route
Route::middleware(['auth','user-role:nsm_fl'])->group(function(){
    Route::get("/nsmfl/home",[HomeController::class,'nsmflHome'])->name('home.nsmfl');
});

//Executive Assistant route
Route::middleware(['auth','user-role:executive_assistant'])->group(function(){
    Route::get("/executive_assistant/home",[HomeController::class,'executive_assistantHome'])->name('home.executive_assistant');
});

//General Admin route
Route::middleware(['auth','user-role:general_admin'])->group(function(){
    Route::get("/general_admin/home",[HomeController::class,'general_adminHome'])->name('home.general_admin');
    Route::get("/admin/itineraries",[GeneralAdminController::class,'adminiindex'])->name('adminiindex');
    Route::post("/admin/store/itineraries",[GeneralAdminController::class,'adminstore'])->name('adminstore');
    Route::get("/admin-show/{itinerary}",[GeneralAdminController::class,'adminshowitinerary'])->name('adminshowitinerary');
    Route::get("/admin-accomplishments",[GeneralAdminController::class,'adminagentaindex'])->name('adminagentaindex');
    Route::get("/admin/create/accomplishment/{itinerary}",[GeneralAdminController::class,'adminconfirmAccomplishment'])->name('adminconfirmAccomplishment');
    Route::post("/admin/create/accomplishment/{itinerary}",[GeneralAdminController::class,'admincreateAccomplishment'])->name('admincreateAccomplishment');
    Route::get("/admin-show/accomplishment/{accomplishment}",[GeneralAdminController::class,'admin_showaccomplishment'])->name('admin_showaccomplishment');
    Route::post("/admin/save/accomplishment",[GeneralAdminController::class,'admin_save'])->name('admin_save');
    Route::get("/admin/my-accomplishment-preview/{liquidation}",[GeneralAdminController::class,'adminmyadownloadpreview'])->name('adminmyadownloadpreview');
    Route::get("/admin/my-accomplishment-download/{liquidation}",[GeneralAdminController::class,'adminmydownloadaccomplishment'])->name('adminmydownloadaccomplishment');
    Route::get("/admin/create/liquidation",[GeneralAdminController::class,'adminagentlindex'])->name('adminagentlindex');
    Route::post("/admin/store/liquidation",[GeneralAdminController::class,'adminliquidationstore'])->name('adminliquidationstore');
    Route::get("/admin/show/{liquidation}",[GeneralAdminController::class,'adminshowliquidation'])->name('adminshowliquidation');
    Route::get("/admin/my-receipts/{liquidation}",[GeneralAdminController::class,'adminreceipt'])->name('adminreceipt');
    Route::get("/admin/liquidation-preview/{liquidation}",[GeneralAdminController::class,'admindownloadpreview'])->name('admindownloadpreview');
    Route::get("/admin/liquidation-download/{liquidation}",[GeneralAdminController::class,'admindownloadliquidation'])->name('admindownloadliquidation');
    Route::get("/admin/liquidations",[GeneralAdminController::class,'adminagentlindexshow'])->name('adminagentlindexshow');
    Route::get("/admin/agent/itinerary/reports",[GeneralAdminController::class,'adminishowuser'])->name('adminishowuser');
    Route::get("/admin/agent/accomplishment/reports",[GeneralAdminController::class,'adminashowuser'])->name('adminashowuser');
    Route::get("/admin/agent/liquidation/reports",[GeneralAdminController::class,'adminlshowuser'])->name('adminashowuser');
    Route::get("/admin/action",[GeneralAdminController::class,'adminaction'])->name('adminaction');
    Route::get("/admin/action2",[GeneralAdminController::class,'adminaction2'])->name('adminaction2');
    Route::get("/admin/action3",[GeneralAdminController::class,'adminaction3'])->name('adminaction3');
    Route::get('/admin/reports/{id}', [GeneralAdminController::class, 'adminuserreports']);
    Route::get('/admin/accomplishment/reports/{id}', [GeneralAdminController::class, 'adminuserreports2']);
    Route::get('/admin/liquidation/reports/{id}', [GeneralAdminController::class, 'adminuserreports3']);
    Route::get("/admin/show/report/agent/{itinerary}-details",[GeneralAdminController::class,'admin_agent_showitinerarydetails'])->name('admin_agent_showitinerarydetails');
    Route::get('/admin/approve/itinerary/{id}', [GeneralAdminController::class, 'adminapprove'])->name('adminapprove');
    Route::get('/admin/disapprove/itinerary/{id}', [GeneralAdminController::class, 'admindisapprove'])->name('admindisapprove');
    Route::get('/admmin/approve/accomplishment/{id}', [GeneralAdminController::class, 'adminapprove2'])->name('adminapprove2');
    Route::get('/admin/disapprove/accomplishment/{id}', [GeneralAdminController::class, 'admindisapprove2'])->name('admindisapprove2');
    Route::get('/admin/approve/liquidation/{id}', [GeneralAdminController::class, 'adminapprove3'])->name('adminapprove3');
    Route::get('/admin/disapprove/liquidation/{id}', [GeneralAdminController::class, 'admindisapprove3'])->name('admindisapprove3');
    Route::get("/admin/show/agent-accomplishment/report/{accomplishment}-details",[GeneralAdminController::class,'admin_agent_showaccomplishmentdetails'])->name('admin_agent_showaccomplishmentdetails');
    Route::get("/admin/agent/accomplishment-preview/{accomplishment}",[GeneralAdminController::class,'adminadownloadpreview'])->name('adminadownloadpreview');
    Route::get("/admin/agent/accomplishment-download/{accomplishment}",[GeneralAdminController::class,'admindownloadaccomplishment'])->name('admindownloadaccomplishment');
    Route::get("/admin/show/agent-liquidation/{liquidation}",[GeneralAdminController::class,'adminshowagentliquidation'])->name('adminshowagentliquidation');
    Route::get("/admin/agent-preview/{liquidation}",[GeneralAdminController::class,'adminagentdownloadpreview'])->name('adminagentdownloadpreview');
    Route::get("/admin/agent-download/{liquidation}",[GeneralAdminController::class,'adminagentdownloadliquidation'])->name('adminagentdownloadliquidation');
    Route::get("/admin/agent-receipts/{liquidation}",[GeneralAdminController::class,'adminagentliquidationreceipt'])->name('adminagentliquidationreceipt');
    Route::get('/admin/agent-itineraries/find/{id}', [GeneralAdminController::class, 'adminfilter'])->name('adminfilter');
    Route::get('/admin/agent-accomplishment/find/{id}', [GeneralAdminController::class, 'adminfilter2'])->name('adminfilter2');
    Route::get('/admin/agent-liquidation/find/{id}', [GeneralAdminController::class, 'adminfilter3'])->name('adminfilter3');
    Route::get('/admin/register', [RegisteredUserController::class, 'create']);
    Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('register');

}); 