<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:office');
    }

    public function getIndex()
    {
        $products = Product::all();
        $goods = array();
        foreach($products as $product)
        {
            $good = array();
            $good['name'] = $product->name;
            $storehouses = array();
            $good['totalFull'] = 0;
            $good['total'] = 0;
            foreach($product->storehouses as $storehouse)
            {
                $store_temp = array();
                $store_temp['name'] = $storehouse->name;
                $store_temp['number'] = $storehouse->remainder->quantity;
                $good['totalFull'] = $good['totalFull'] + $storehouse->remainder->quantity;
                $store_temp['requests']['up'] = array();
                $store_temp['requests']['down'] = array();
                $store_temp['requests']['totalUp'] = 0;
                $store_temp['requests']['totalDown'] = 0;
                foreach($storehouse->requests()->where('remainder_id',$storehouse->remainder->id)->get() as $request)
                {
                    if($request->isExport && $request->isActive == 1) {
                        $up = array();
                        $up['id'] = $request->id;
                        $up['who'] = $request->client->name;
                        $up['number'] = $request->quantity;
                        $store_temp['requests']['totalUp'] = $store_temp['requests']['totalUp'] + $request->quantity;
                        $up['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
                        array_push($store_temp['requests']['up'],$up);
                    }
                    elseif(!$request->isExport && $request->isActive == 1) {
                        $down = array();
                        $down['id'] = $request->id;
                        $down['who'] = $request->client->name;
                        $down['number'] = $request->quantity;
                        $store_temp['requests']['totalDown'] = $store_temp['requests']['totalDown'] + $request->quantity;
                        $down['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
                        array_push($store_temp['requests']['down'],$down);
                    }
                }
                $good['total'] = $good['total'] + $store_temp['requests']['totalUp'];
                if(empty($store_temp['requests']['up']) || !isset($store_temp['requests']['up']))
                    $store_temp['requests']['up'] = false;
                if(empty($store_temp['requests']['down']) || !isset($store_temp['requests']['down']))
                    $store_temp['requests']['down'] = false;
                array_push($storehouses,$store_temp);
            }
            $good['stores'] = $storehouses;
            array_push($goods,$good);
        }
        $goods = json_encode($goods);
    	return view('office.remainder')->withGoods($goods);
    }
}
