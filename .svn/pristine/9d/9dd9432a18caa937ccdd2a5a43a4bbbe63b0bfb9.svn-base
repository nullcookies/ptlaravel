<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OposReceipt;
use App\Models\OposReceiptproduct;
use DB;
use App\Models\Product;
use Auth;
use Carbon;
use Log;

class OpossumStaffController extends Controller
{
	public function oposStaffList()
	{
		$user_id= Auth::user()->id;
		$staffs = DB::select(DB::raw("
                SELECT 
                    u.id as uid,
                    m.id as mid,
                    u.email,m.name as mname,
                    s.name as sname,r.name as rname,
                    concat(u.first_name,' ',u.last_name) as name ,
                    c.id as company_id
                    FROM	users u,
                            roles r,
                            role_users ru,
                            company c,
                            member m 
                            LEFT JOIN nstaff s ON m.id = s.member_id 
                    WHERE 
                    m.user_id = u.id 
                    AND ru.user_id = u.id 
                    AND ru.role_id = r.id 
                    
                    AND (r.slug = 'mbr' OR
						 r.slug = 'mba' OR
						 r.slug = 'hcu' OR
						 r.slug = 'hca' OR
						 r.slug = 'ebu' OR
						 r.slug = 'eba')

                    AND m.type='member'
					AND m.company_id = c.id
					AND m.status = 'active'
					AND c.owner_user_id = $user_id
					GROUP BY	u.id"
        ));
        foreach ($staffs as $staff){
            $staff->attendance = DB::table('hcap_attendance')->where('staff_user_id', $staff->uid)->count();
        }

        // echo '<pre>'; print_r($staffs); die();

		return view('opposum.trunk.oposstafflist',compact('staffs'));
	}


	public function oposStaffProduct()
	{
		return view('opposum.trunk.oposstaffproduct');
	}
}
?>