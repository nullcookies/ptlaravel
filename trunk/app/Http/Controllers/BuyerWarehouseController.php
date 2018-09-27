<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class BuyerWarehouseController extends Controller
{

    public function __construct()
    {

    }

    public function get_buyer_warehouse_data(Request $request, $id = null)
    {

        //dd($id);
        if (!Auth::check()) {
            return "Please login";
        }

        //if (isset($request->userid)) {
           // dd($id);
            $id = $request->userid;

            if ($id != null) {
                $user_id = $id;
            } else {
                $user_id = Auth::user()->id;
            }

            $selluser   = User::find($user_id);

        /*Lets get the Merchant Id */
       $company =  DB::table('member')->select('company_id')->where('user_id', $user_id)->first();
      //  dd($company->company_id);
        $merchant = DB::table('company')->select('owner_user_id')->where('id', $company->company_id)->first();
      //  dd($merchant->owner_user_id);

            $warehouses = DB::table("warehouse")
                ->join("fairlocation", "fairlocation.id", "=", "warehouse.location_id")
            // ->join("user","user.id","=","warehouse.user_id")
                ->whereNull("fairlocation.deleted_at")
                ->whereNull("warehouse.deleted_at")
                ->where("fairlocation.user_id", $merchant->owner_user_id)
                ->select("fairlocation.*", "warehouse.id as warehouse_id", "fairlocation.location as branch_name")
                ->groupBy("warehouse_id")
            // ->toSql();
                ->get();
      //  dump($warehouses);

            return view('buyer.newbuyerinformation.functions.buyer_warehouse')
                ->with('selluser', $selluser)
                ->with('warehouses', $warehouses);
       // }
    }
}
