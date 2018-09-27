<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Rack;

use QrCode;
use DB;
use Log;
use Carbon;
use File;
use Auth;
class SellerRackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request,$uid=NULL)
    {
        $ret=array();

        $ret["status"]="failure";
        /*Check if logged in*/
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access.";
            return response()->json($ret);
        }
        /* Check if rack_no is valid and is passed */
        if (empty($request->warehouse_id)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
        /* Check ownership of warehouse */
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
        $is_owner=DB::table("warehouse")->join("fairlocation","fairlocation.id","=","warehouse.location_id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.user_id",$user_id)
        ->where("warehouse.id",$request->warehouse_id)
        ->first();
        if (empty($is_owner)) {
            $ret["long_message"]="Unauthorized Access!";
            return response()->json($ret);
        }
        /* Prevent duplicate rack_no  Obsolete for now 
        $does_exist=Rack::where("rack_no",$request->rack_no)->where("warehouse_id",$request->warehouse_id)->whereNull("deleted_at")->first();
        if (!empty($does_exist)) {
            $ret["long_message"]="Rack No already exists";
            return response()->json($ret);
        }*/
        $warehouse_id=$request->warehouse_id;
        $rack_no=1;
        $max_rack=DB::table("rack")
        ->whereNull("deleted_at")
        ->where("warehouse_id",$warehouse_id)
        ->orderBy("rack_no","desc")
        ->first();
        
        
        if (!empty($max_rack)) {
            # code...
            $rack_no=$max_rack->rack_no+1;
        }

        try {
            $r= new Rack;
            $r->rack_no=$rack_no;
         /*   $r->name=$request->name;
            $r->description=$request->description;*/
            $r->warehouse_id=$warehouse_id;
            $r->save();
            $ret["status"]="success";
            $ret["rack_id"]=$r->id;
        } catch (\Exception $e) {
            $ret["long_message"]="Server error happened";
            Log::info('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
        }

        return response()->json($ret);
    }

    /**
     * Displays all/or was part of  the product in the rack , along with their quantity.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rack_product_info(Request $request,$uid=NULL)
    {
        $ret=array();
        if (!Auth::check()) {
            # code...
            $ret["long_message"]="Unauthorized access. Please login.";
            return response()->json($ret);
        }
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
    
        if (empty($request->warehouse_id) or empty($request->rack_no)) {
            # code...
            $ret["long_message"]="Bad parameters passed! Reload page and try again.";
            return response()->json($ret);
        }
        $warehouse_id=$request->warehouse_id;
        $rack_no=$request->rack_no;
        /* Check ownership of warehouse */
       
        $is_owner=DB::table("warehouse")->join("fairlocation","fairlocation.id","=","warehouse.location_id")
        ->whereNull("fairlocation.deleted_at")
        ->whereNull("warehouse.deleted_at")
        ->where("fairlocation.user_id",$user_id)
        ->where("warehouse.id",$warehouse_id)
        ->select("fairlocation.id")
        ->first();
        if (empty($is_owner)) {
       //     $ret["long_message"]="Unauthorized Access!";
            $ret["long_message"]="Unauthorized Access. Please choose correct warehouse.";
            return response()->json($ret);
        }
        $fairlocation_id=$is_owner->id;

        try{
            $i=0;
            $query="SELECT
                
                    product.name,
                    product.thumb_photo,
                    '--' expiry_date,
                  
                    
                    stockreport.id,
                    product.id,
                    SUM(
                        CASE

                            WHEN stockreport.ttype=NULL then 0
                             WHEN stockreport.ttype = 'stocktake' THEN
                            CAST(stockreportproduct.received as SIGNED)-CAST(stockreportproduct.opening_balance AS SIGNED)
                            WHEN stockreport.ttype='tin' then stockreportproduct.quantity
                           WHEN stockreport.ttype='tout' then - stockreportproduct.quantity
                            WHEN stockreport.ttype='treport' then 
                               CASE WHEN 
                                    stockreport.creator_location_id=$fairlocation_id
                                    THEN -stockreportproduct.quantity
                                    ELSE
                                    stockreportproduct.quantity
                                END
                            ELSE 0
                        END
                    ) as quantity

                    FROM 
                  
                    rack
                    JOIN (SELECT DISTINCT stockreport_id,rack_id from stockreportrack) r on r.rack_id=rack.id

                    LEFT JOIN stockreport ON  stockreport.id= r.stockreport_id
                    
                    LEFT JOIN stockreportproduct ON stockreportproduct.stockreport_id = r.stockreport_id
                    LEFT JOIN product ON product.id=stockreportproduct.product_id


                    WHERE 
                    rack.deleted_at IS NULL
                    AND rack.warehouse_id=$warehouse_id 
                   
                    AND rack.rack_no=$rack_no
                    AND stockreport.status='confirmed'
                    AND stockreport.deleted_at IS NULL
                    AND stockreportproduct.deleted_at IS NULL
                    AND stockreportproduct.status='checked'
                    AND product.deleted_at IS NULL
                    AND stockreport.creator_location_id=$fairlocation_id

                  
                  
                    group by  product.name";
            /*return $query;*/
            $raw_data=DB::select(DB::raw($query));
           
           

            $ret["status"]="success";
            $ret["data"]=$raw_data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::info("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

}
