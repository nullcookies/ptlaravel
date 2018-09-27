<?php

namespace App\Http\Controllers;

use App\Http\Repository\RecipeRepo;
use App\Models\Merchant;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Log;
use Illuminate\Support\Facades\Config;

class RecipeController extends Controller 
{
	protected $repo;
	function __construct(RecipeRepo $repo) {
		$this->repo = $repo;
	}

	public function listrecipe($product_id)
    {
        return view("product.listrecipe",compact('product_id'));
    }

    public function showrecipematerial()
    {
    	return $this->repo->getRawMaterial();
    }

    public function recipeQ1(){
    	$matches = '';        
        $user_id = \Auth::user()->id;
        $merchant = \App\Models\Merchant::where('user_id',$user_id)->first();
        $products =$this->repo->getRawMaterial();

        $units = array();
        try {
		/* Make sure table_schema matches current name of active DB */
            $units = DB::select(DB::raw("
    		select
    			column_type
    		from
    			information_schema.columns
    		where
    			table_schema='".Config::get('app.DBNAME')."' and
    			table_name='q1def' and
    			column_name='unit'"))[0]->column_type;

            preg_match("/^enum\(\'(.*)\'\)$/", $units, $matches);
            $units = explode("','", $matches[1]);
        } 
        catch (\Exception $e) {
            Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            return Response()->json(['error' => true]);
        }       
        
        return view('product.recipeq1',[
            'products' => $products, 
            'selluser' => $merchant,
            'units'    => $units
        ]);
    }

    public function getUnit($product_id){

        $q1def = DB::table("q1def")
                ->select('unit')
                ->where('product_id',$product_id)
                ->orderby('id','desc')
                ->first();

        if(count($q1def) > 0)
        {
            return $unit = $q1def->unit;
        }
        else{
            return $unit = '';
        }       
    }

    public function saveRawMaterial(Request $request){

        $raw_product_ids = $request->raw_product_id;
        $measuredata = $request->measuredata;
        $delete = DB::table("rawmaterial")
                ->where('item_product_id',$request->item_product_id)->delete();
                
        foreach ($raw_product_ids as $key => $value) {

            $d=DB::table("rawmaterial")
                ->insertgetId([
                    "item_product_id"=>$request->item_product_id,
                    "raw_product_id"=>$value,
                    "raw_qty" => $measuredata[$key],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
        }
    }
}

?>
