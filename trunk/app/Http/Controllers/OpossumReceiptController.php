<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Carbon;
use Auth;

class OpossumReceiptController extends Controller
{
	public function getBranchSales(Request $request)
    {
    	$reports = DB::table("opos_receipt")
			        ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
			        ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
			        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
			        ->leftJoin('opos_servicecharge','opos_servicecharge.id','=','opos_receiptproduct.servicecharge_id')
			        ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
			        ->leftJoin('opos_servicecharge as sc','sc.id','=','opos_receipt.servicecharge_id')
					->select('sc.value',
						DB::raw(
			           "SUM(opos_receiptproduct.quantity*(opos_receiptproduct.price)) as amount"
						),
						"sc.value as servicecharge",
						"opos_receipt.service_tax",
						"opos_receipt.status",
						"opos_receipt.cash_received",
						"opos_receipt.otherpoints",
						"opos_receipt.payment_type",
						"opos_receipt.mode",
						"opos_receipt.round",
			            DB::raw(
			                "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
			        );

		$reports = $reports->whereRaw('opos_receipt.status IN ("completed")')
						   ->whereNull("opos_receipt.deleted_at")
						   ->whereRaw('fairlocation.id = '.$request->id);

        $report1 = $reports->toSql();
        $report2 = $reports->toSql();

        $monthlyAmount = DB::select($report2.' and opos_receipt.created_at like "'.
			date('Y-m',strtotime(Carbon::today())).'%" GROUP BY opos_receipt.id');
        
        $todayAmount = DB::select($report1.' and opos_receipt.created_at like "'.
			date('Y-m-d',strtotime(Carbon::today())).'%" GROUP BY opos_receipt.id');
        $monthtotal=0;
        $todaytotal=0;
          foreach ($monthlyAmount as $r) {
			/* Original price less discount */

        	if ($r->mode=="inclusive") {
        		$r->amount = $r->amount - $r->discount;
        		$sc=0;
                $amount=$r->amount/(1+($r->service_tax/100));
                $sst=$r->amount-$amount;
                 $monthtotal += $amount;

				/*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/

				/*$r->amount=$r->amount/(1+($r->service_tax/100));*/

			}else{
				$r->amount = $r->amount - $r->discount;
				$sc=($r->servicecharge*$r->amount)/100;
				$st=($r->service_tax*$r->amount)/100;
				$monthtotal += $r->amount;
                                   
			}
			
        }

        foreach ($todayAmount as $r) {
			/* Original price less discount */

        	if ($r->mode=="inclusive") {
        		$r->amount = $r->amount - $r->discount;
        		$sc=0;
                $amount=$r->amount/(1+($r->service_tax/100));
                $sst=$r->amount-$amount;
                 $todaytotal += $amount;

				/*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/

				/*$r->amount=$r->amount/(1+($r->service_tax/100));*/

			}else{
				$r->amount = $r->amount - $r->discount;
				$sc=($r->servicecharge*$r->amount)/100;
				$st=($r->service_tax*$r->amount)/100;
				$todaytotal += $r->amount;
                                   
			}
        }

    	$cash=0;
		$creditcard=0;
		$otherpoints=0;
		$reports->whereRaw('Date(opos_receipt.created_at) = CURDATE()')->
			groupBy("opos_receipt.id")->
			orderBy("opos_receipt.id", "desc");

		$reports = $reports->orderBy("opos_receipt.created_at","DESC")->
			get();
		foreach ($reports as $r) {
			//Log::debug(json_encode($r));
			/* Original price less discount */
			
        	$r->amount = $r->amount - $r->discount;

			/* Service charge against total */
			$scharge = $r->amount * (($r->value)/100);

			/*Service Tax*/
			$sst=0;
			if ($r->mode=="exclusive") {
				$sst=$r->amount * (($r->service_tax)/100);
			}
			/* Final total includes service charge */
        	$r->amount = $r->amount +floor($scharge)+floor($sst)+$r->round; 
        /*	dump("amount  =".$r->amount);*/
			/*
			Log::debug("amount  =".$r->amount);
			Log::debug("discount=".$r->discount);
			Log::debug("scharge =".$scharge);
			*/
			/*For csh and credit*/
			if($r->status=="completed"){
				if ($r->cash_received>=$r->amount) {
					# code...
					$cash+=$r->amount;
				}else{
					if ($r->cash_received<$r->amount) {
						# code...
						$cash+=$r->cash_received;
						if ($r->payment_type=="creditcard") {
							# code...
							/*dump($r->amount);
							dump($r->otherpoints);
							dump($r->cash_received);*/
							$creditcard+=($r->amount-($r->otherpoints*100)-$r->cash_received);
						}
						
						
					}
				}

				$otherpoints+=$r->otherpoints;
			}
        }
		/*$otherpoints = DB::table('opos_receipt')
						->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
				        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
						 ->select(DB::raw("SUM(opos_receipt.otherpoints) as otherpoints"))
			   			 ->whereRaw('opos_receipt.status IN ("completed")')
			   			 ->whereRaw('Date(opos_receipt.created_at) = CURDATE()')
			   			 ->whereRaw('fairlocation.id = '.$request->id)
			   			 ->first();*/

		$currency= DB::table('currency')->where('active', 1)->first()->code;

		$location = $request->location;

		return view('opposum.trunk.branchsales')
				->with('cash',				$cash)
				->with('creditcard',		$creditcard)
				->with('otherpoints',		$otherpoints)
				->with('currency',			$currency)
				->with('todayAmount',		$todaytotal)
				->with('location',			$location)
				->with('monthlyAmount',		$monthtotal)
				;
    }

    public function getbalance($terminal_id=NULL,$pay_type,$branch_id=NULL)
	{  
        if($pay_type == "cash")
        {
        	$query = "SELECT opr.cash_received as total_amount,        
		            'in' as mode,
		            SUM(opcp.quantity*(opcp.price)) as amount,
		            SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
		            opsc.value as service_charges,
		            opr.payment_type as ptype
				FROM 
					opos_receipt opr
					LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
					JOIN users u on u.id=opr.staff_user_id
					LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id
		        where DATE(opr.created_at) = CURDATE()
		        AND opr.status IN ('completed')";
		    if($terminal_id != null)
		    {
		     	$query .=" AND opr.terminal_id=".$terminal_id;
		    }
		    if($branch_id != null)
		    {
		     	$query .=" AND opr.terminal_id IN (select terminal_id from opos_locationterminal join fairlocation on fairlocation.id = opos_locationterminal.location_id where fairlocation.id =".$branch_id." )";
		    }
		    $query .=" AND opcp.deleted_at IS NULL
				GROUP BY opr.id
				ORDER BY opr.updated_at desc";

			$data = DB::select($query); 
        }
        else
        {
        	$query = "SELECT ((SUM(opcp.quantity*(opcp.price)) - opr.cash_received )) - if(opr.otherpoints is null,0,opr.otherpoints *100)  as total_amount,        
		            'in' as mode,
		            SUM(opcp.quantity*(opcp.price)) as amount,
		            SUM((opcp.discount*opcp.quantity*opcp.price)/100) as discount,
		            opsc.value as service_charges,
		            opr.payment_type as ptype
				FROM 
					opos_receipt opr
					LEFT JOIN opos_receiptproduct opcp on opcp.receipt_id=opr.id
					JOIN users u on u.id=opr.staff_user_id
					LEFT JOIN opos_servicecharge opsc on opsc.id=opr.servicecharge_id 

		        where DATE(opr.created_at) = CURDATE()
				AND opr.status IN ('completed')";

		    if($terminal_id != null)
		    {
		     	$query .=" AND opr.terminal_id=".$terminal_id;
		    }
		    if($branch_id != null)
		     {
		     	$query .=" AND opr.terminal_id IN (select terminal_id from opos_locationterminal join fairlocation on fairlocation.id = opos_locationterminal.location_id where fairlocation.id =".$branch_id." )";
		     }

		    $query .=" AND opcp.deleted_at IS NULL
		    		AND opr.payment_type ='".$pay_type."'
					GROUP BY opr.id
					ORDER BY opr.updated_at desc";

			$data=DB::select($query);
        }

		Log::debug('************  getbalance() *****************');
		Log::debug(json_encode($data));
      
        $cmlbalance=0;
        foreach($data as $d){
			
			if($d->total_amount > $d->amount)
        	{
        		$amount = $d->amount;
        	}
        	else
        	{
        		$amount = $d->total_amount;
        	}
            
			if ($d->mode=="in") {
				$cmlbalance+=$amount;
			}else{
				$cmlbalance-=$amount;
			}
        }
        return $cmlbalance;
    }

    public function getRefunds(Request $r)
    {
    	die("000");
    	$currency= DB::table('currency')->where('active', 1)->first()->code;
    	return view('opposum.trunk.getrefund',compact('currency'));
    }

    public function confirmRefund(Request $r)
    {
    	$currency= DB::table('currency')->where('active', 1)->first()->code;
    	return view('opposum.trunk.confirmrefund',compact('currency'));
    }
}
?>