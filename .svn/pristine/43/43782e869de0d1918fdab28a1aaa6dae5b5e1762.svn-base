<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Carbon;
use Auth;
class OposEodController extends Controller
{
  //-----------------------------------------
  // Created by Zurez
  //-----------------------------------------
  
  public function last_eod_summary($log_id,$uid=NULL)
  {
      $ret=array();
      $ret["status"]="failure";
      if(!Auth::check()){return "";}
      $user_id=Auth::user()->id;
      if(!empty($uid) and Auth::user()->hasRole("adm")){
          $user_id=$uid;
      }
      try{
         
         $log=DB::table('opos_logterminal')
         ->where('id',$log_id)
         ->whereNull('deleted_at')
         ->orderBy('created_at','DESC')
         ->first();
         $terminal_id=$log->terminal_id;
         if (empty($log)) {
             # code...
            return "";
         }
          $location_id=DB::table("opos_locationterminal")
        ->where('terminal_id',$terminal_id)->pluck('location_id');
        $location=DB::table('fairlocation')->where('id',$location_id)->first();

                $reports = DB::table("opos_receipt")
                    ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
                
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
                        DB::raw(
                            "SUM((opos_receiptproduct.quantity*opos_receiptproduct.price*opos_receiptproduct.discount)/100) as discount")
                        
                      
                    )->whereRaw('opos_receipt.status IN ("completed")')
                        ->whereNull("opos_receipt.deleted_at");

        $todayAmount = $reports     
                           ->whereRaw('opos_receipt.terminal_id = '.$terminal_id)
                           ->whereRaw('opos_receipt.created_at BETWEEN "'.$log->start_work.'" AND "'.$log->eod.'"')
                           ->groupBy('opos_receipt.id')
                           ->get()
                           ;
        $branchsalerecords=$reports->join('opos_locationterminal','opos_locationterminal.terminal_id','=','opos_receipt.terminal_id')
        ->where('opos_locationterminal.location_id',$location_id)

        ->whereRaw('opos_receipt.created_at BETWEEN "'.$log->start_work.'" AND "'.$log->eod.'"')
                           ->groupBy('opos_receipt.id')
                           ->get()
                           ;
        
 
        $todaytotal=0;
        $branchsale=0;
        foreach ($branchsalerecords as $r) {
            /* Original price less discount */

            if ($r->mode=="inclusive") {
                $r->amount = $r->amount - $r->discount;
                $sc=0;
                $amount=$r->amount/(1+($r->service_tax/100));
                //$sst=$r->amount-$amount;
                $branchsale += $amount;

                /*$s=floatval($r->amount) * (($r->service_tax)/100.0);*/

                /*$r->amount=$r->amount/(1+($r->service_tax/100));*/

            }else{
                $r->amount = $r->amount - $r->discount;
           
                $branchsale += $r->amount;
                                   
            }
        }
         $todayservicecharge=0;$todaysst=0;
        foreach ($todayAmount as $r) {
            /* Original price less discount */

            if ($r->mode=="inclusive") {
                $r->amount = $r->amount - $r->discount;
                $sc=0;
                $amount=$r->amount/(1+($r->service_tax/100));
                $todaysst+=floor($r->amount-$amount);
                $todayservicecharge+=floor($sc);
                $todaytotal += $amount;

             
                                    

            }else{
                $r->amount = $r->amount - $r->discount;
                $todayservicecharge+=floor(($r->servicecharge*$r->amount)/100);
                $todaysst=floor(($r->service_tax*$r->amount)/100);
                $todaytotal += $r->amount;

             
                                   
            }
        }

        $cash=0;
        $creditcard=0;
        $otherpoints=0;
        
        foreach ($todayAmount as $r) {
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
            $r->amount = $r->amount + $scharge+$sst; 
        /*  dump("amount  =".$r->amount);*/
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
       
         $company=DB::table("company")
                    ->join("fairlocation","fairlocation.user_id","=","company.owner_user_id")
                    ->join("merchant","merchant.user_id","=","company.owner_user_id")
                    ->join("address","address.id","=","merchant.address_id")
                    ->leftjoin("address as address2","address2.id","=","fairlocation.address_id")
                    ->select(
                        DB::raw("IF(fairlocation.address_preference = 'branch', address2.line1, address.line1) as line1"),
                        DB::raw("IF(fairlocation.address_preference = 'branch', address2.line2, address.line2) as line2"),
                        DB::raw("IF(fairlocation.address_preference = 'branch', address2.line3, address.line3) as line3"),
                        DB::raw("IF(fairlocation.address_preference = 'branch', address2.line4, address.line4) as line4"),
                        'company.dispname',
                        'merchant.gst','merchant.business_reg_no'
                     )
                    ->where("fairlocation.id",$location_id)
                    ->first();

         $bfunction="";
        $terminal=DB::table("opos_terminal")->
                where("id",$terminal_id)->
                whereNull("deleted_at")->
                first();
        $bfunction=$terminal->bfunction;
        $localLogo=$terminal->local_logo;
        $show_sst_no=$terminal->show_sst_no;
        if (!empty($company)) {
            
            
            
            /*If terminal has a local addres*/
            if (!empty($terminal->address_id)) {
                $address=DB::table("address")
                ->where('id',$terminal->address_id)
                ->first();
                if (!empty($address)) {
                    # code...
                    $company->line1=$address->line1;
                    $company->line2=$address->line2;
                    $company->line3=$address->line3;

                }
            }
            
        }
        $staff=DB::table("users")->where("id",$user_id)->select("first_name","last_name")->first();
        $first_name=$staff->first_name;
        $last_name=$staff->last_name;
        $staffname=$first_name." ".$last_name;
        $staffid=sprintf("%010d",$user_id);
        return view('seller.opossum_document.eod_summary',compact('company','cash','creditcard','branchsale','otherpoints','todaytotal','location','terminal_id','log','todaysst','todayservicecharge','show_sst_no','staffid','staffname'));
         
      }
      catch(\Exception $e){
          dump($e);
          Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
      }
      return response()->json($ret);
  }
  
}
