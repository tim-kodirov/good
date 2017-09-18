<?php

namespace App\Http\Controllers;

use App\Export;
use App\Product;
use App\Storehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreHouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:storehouse');
    }

    public function getIndex()
    {
        $storehouse = Auth::user();
        $goods = array();
        foreach($storehouse->products as $product)
        {
            $good = array();
            $good['id'] = $product->id;
            $good['name'] = $product->name;
            $good['number'] = $product->remainder->quantity;
            $good['requests']['up'] = array();
            $good['requests']['down'] = array();
            foreach($product->requests as $request)
            {
                if($request->isExport && $request->isActive)
                {
                    $up = array();
                    $up['id'] = $request->id;
                    $up['who'] = $request->client->name;
                    $up['number'] = $request->quantity;
                    $up['date'] = $request->created_at;
                    array_push($good['requests']['up'],$up);
                }
                elseif(!$request->isExport && $request->isActive)
                {
                    $down = array();
                    $down['id'] = $request->id;
                    $down['who'] = $request->client->name;
                    $down['number'] = $request->quantity;
                    $down['date'] = $request->created_at;
                    array_push($good['requests']['down'],$down);
                }
            }
            if(empty($good['requests']['up']) || !isset($good['requests']['up']))
                $good['requests']['up'] = false;
            if(empty($good['requests']['down']) || !isset($good['requests']['down']))
                $good['requests']['down'] = false;
            array_push($goods,$good);
        }
        $goods = json_encode($goods);
    	return view('storehouse.remainder')->withGoods($goods);
    }

    public function getImport()
    {

    }

    public function getExport()
    {

    }

    public function productExport(Request $request)
    {
        $storehouse = Auth::user();
        $product = $storehouse->products()->findOrFail($request->export_product_id);
        $product->remainder->quantity = $product->remainder->quantity - $request->export_product_quantity;
        $product->remainder->save();
        $export = new Export;
        $export->remainder_id = $product->remainder->id;
        $export->quantity = $request->export_product_quantity;
        $export->fromRequest = false;
        $export->save();
    }

    public function productImport(Request $request)
    {

    }
    /*Export made according to request from office*/
    public function requestExportAccept(Request $request)
    {

    }
    /*Import according to request from office*/
    public function requestImportAccept(Request $request)
    {

    }

    public function requestExportReject(Request $request)
    {

    }

    public function requestImportReject(Request $reject)
    {

    }
    /*Add new product to list*/
    public function createProduct(Request $request)
    {
        $storehouses = Storehouse::all();
        $product = new Product;
        $product->name = $request->product_name;
        $product->save();
        foreach($storehouses as $storehouse)
        {
            $storehouse->products()->attach($product->id);
        }
        return back();
    }

    public function returnExport(Request $request, $id)
    {

    }
}
