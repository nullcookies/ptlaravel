<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\SalesStaff;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesStaffRequest;
use DB;
class SalesStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $staff = SalesStaff::all();
        $users = User::all();
        $merchants = Merchant::all();
        return view("sales_staff.index",[
            'salesStaff' => $staff,
            'users' =>$users,
            'merchants'=>$merchants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_is_merchant=False;
        // Check if user is a merchant
        $m= DB::table('merchant')->where('user_id',$request->get('user_id'))->first();
        if (!is_null($m)) {
            $user_is_merchant=True;
        }
        $staff = new SalesStaff();
        $staff->user_id = $request->get('user_id');
        $staff->type = $request->get('type');
        $staff->target_merchant = $request->get('target_merchant');
        $staff->target_revenue = $request->get('target_revenue');
        $commission= $request->get('commission');
        if ($user_is_merchant==True) {
            $commission=0;
        }
        $staff->commission = $commission;
        $staff->bonus = $request->get('bonus');
        $staff->save();
        return json_encode($staff);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $staff = SalesStaff::find($id);
        return json_encode($staff);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $staff = SalesStaff::find($id);
        $staff->user_id = $request->get('user_id');
        $staff->type = $request->get('type');
        $staff->target_merchant = $request->get('target_merchant');
        $staff->target_revenue = $request->get('target_revenue');
        $staff->commission = $request->get('commission');
        $staff->bonus = $request->get('bonus');
        $staff->save();
        return json_encode($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $staff = SalesStaff::find($id);
        $staff->delete();
        return json_encode(array('message'=>true));
    }
}
