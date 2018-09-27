<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HumanCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function approveHumanCap() {
        $inputs = \Illuminate\Support\Facades\Input::all();
        if(!empty($inputs['id']) && !empty($inputs['doStatus']) && !empty($inputs['role']) ){
         return \App\Classes\AdminApproveHelper::approveUser($inputs);

      }
    }	 
	 
    public function saveHumanCapRemarks() {
        $inputs = \Illuminate\Support\Facades\Input::all();
		$res = "";
        if(!empty($inputs['id']) && !empty($inputs['remarks']) && !empty($inputs['role']) ){
			$res = \App\Classes\AdminApproveHelper::saveRemarks($inputs);
			echo $res;
		}
		//echo "Hola";
    }
	
    public function humancap_remarks($id){
		$remarks = DB::select(DB::raw("select remark.remark, remark.user_id, DATE_FORMAT(remark.created_at,'%d%b%y %H:%i') as created_at, remark.status, nhumancapid.nhumancap_id, nbuyerid.nbuyer_id from remark inner join humancapremark on humancapremark.remark_id = remark.id left join humancap on humancap.id = humancapremark.humancap_id left join nhumancapid on humancap.user_id = nhumancapid.user_id left join nbuyerid on remark.user_id = nbuyerid.user_id where humancapremark.humancap_id = " . $id . " order by remark.created_at desc"));

		return json_encode($remarks);
	}
	
	public function approval($id)
    {
		$humancaps = DB::table('humancap')->leftJoin('nhumancapid','humancap.user_id','=','nhumancapid.user_id')
			->select(DB::raw("humancap.*,
				IFNULL(nhumancapid.nhumancap_id,LPAD(humancap.id,16,'E')) as
					humancap_id"))
			->where('humancap.id',$id)
			->orderBY('humancap.created_at', 'desc')->get();
			return view('master.humancap_approval')->with('humancaps',$humancaps);
	}
	
	public function master()
    {
		$hrole = DB::table('roles')->where('slug','hcu')->first();
		$humancaps = [];
		if(!is_null($hrole)){
			$humancaps = DB::table('merchant')->leftJoin('nsellerid','merchant.user_id','=','nsellerid.user_id')
			->join('role_users','role_users.user_id','=','merchant.user_id')
			->where('role_users.role_id',$hrole->id)
			->select(DB::raw("merchant.*,
				IFNULL(nsellerid.nseller_id,LPAD(merchant.id,16,'E')) as
					humancap_id"))
			->distinct()
			->orderBY('merchant.created_at', 'desc')->get();
			foreach($humancaps as $humancap){
				$memberc = 0;
				$company = DB::table('company')->where('owner_user_id',$humancap->user_id)->first();
				if(!is_null($company)){
					$membersc = DB::table('member')->where('company_id',$company->id)->where('type','member')->count();
				}
				$humancap->staff = $memberc;
			}
		}
		return view('master.humancap')->with('humancaps',$humancaps);
    } 
	 
    public function index()
    {
        //
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
        //
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
    }
}
