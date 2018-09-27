<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderStockReport;
use App\Models\DeliveryOrdertProduct;
use App\Models\Employee;
use App\Models\Fairlocation;
use App\Models\LocationProduct;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\NdoID;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\Stockreport;
use App\Models\Stockreportproduct;
use App\Models\Tproduct;
use App\Models\User;
use App\Models\POrder;
use Carbon\Carbon;

use function Clue\StreamFilter\fun;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use Session;
use Log;
use Auth;

class RefrigeratorController extends Controller {

    public function getDeliveryMasterDetails() {
        return view('admin.delivery_details');
    }

    public function index($user_id = null) {
        if (!Auth::check()) {
            return view("common.generic")
                            ->with("message_type", "error")
                            ->with("message", "Please login to access this view")
            ;
        }
        if ($user_id == null) {
            $user_id = Auth::user()->id;
        }
        $selluser = User::find($user_id);
        $cporders = POrder::join('ordertproduct', 'ordertproduct.porder_id', '=', 'porder.id')
                ->where('mode', '=', 'gator')
                ->get([
                    'porder.id',
                    'ordertproduct.porder_id',
                    'ordertproduct.quantity',
                    'ordertproduct.order_price',
                ])
                ->groupBy('id');


        $merchant_id = Merchant::where('user_id', $user_id)->pluck('id');


        if (isset($id)) {
            DeliveryOrder::whereIn('id', $id)->update([
                'status' => 'confirmed'
            ]);
        }

        $company_id = Company::where('owner_user_id', $user_id)->pluck('id');

        $delivery_men = DB::select("select m.id,
        m.user_id,
        m.email,
        r.name,
        u.username,
        u.first_name,
        u.last_name from member m,
        role_users ru,
        users u, 
        roles r
        where ru.user_id=u.id 
        and ru.role_id=r.id 
        and m.user_id=u.id 
        and m.company_id=$company_id 
        and m.type='member' 
        and r.slug='dlv'");


        $dils = $all_locations = Fairlocation::where('user_id', '=', $user_id)->get();

        return view('seller.refrigerator.refrigeratorfirst', compact('delivery_orders', 'delivery_men', 'selluser', 'cporders', 'dils', 'user_id'));
    }

}
