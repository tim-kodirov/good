<?php

namespace App\Http\Controllers;

use App\Client;
use App\Product;
use App\Remainder;
use App\Storehouse;
use Carbon\Carbon;
use App\Request as OfficeRequest;
use Illuminate\Http\Request;

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
            $good['id'] = $product->id;
            $good['name'] = $product->name;
            $storehouses = array();
            $good['totalFull'] = 0;
            $good['total'] = 0;
            foreach($product->storehouses as $storehouse)
            {
                $store_temp = array();
                $store_temp['remainder_id'] = $storehouse->remainder->id;
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
            $good['total'] = $good['totalFull']-$good['total'];
            $good['stores'] = $storehouses;
            array_push($goods,$good);
        }
        $goods = json_encode($goods);
    	return view('office.remainder')->withGoods($goods);
    }

    public function createRequest(Request $request)
    {
        if(!empty($request->request_quantity) && !empty($request->client_name)/* && !empty($request->client_contacts)*/){
            if(Remainder::where('id',$request->remainder_id)->exists()){
                $officeRequest = new OfficeRequest;
                $officeRequest->remainder_id = $request->remainder_id;
                if(Client::where('name',$request->client_name)->exists()){
                    $client = Client::where('name',$request->import_client_name)->get();
                    $officeRequest->client_id = $client->id;
                }
                else{
                    $client = new Client;
                    $client->name = $request->client_name;
                    $client->contacts = "?";//till implementation
                    $client->save();
                    $officeRequest->client_id = $client->id;
                }
                $officeRequest->isActive = true;
                $officeRequest->isExport = $request->request_isExport;
                $officeRequest->quantity = $request->request_quantity;
                $officeRequest->save();
            }
        }
        return back();
    }

    public function editRequest(Request $request)
    {
        if(!empty($request->selected_requests_id)) {
            $officeRequests = OfficeRequest::whereIn('id',$request->selected_requests_id)->get();
            foreach($officeRequests as $officeRequest)
            {

            }
        }
        return back();
    }

    public function deleteRequest(Request $request)
    {
        if(!empty($request->selected_requests_id)) {
            $officeRequests = OfficeRequest::whereIn('id',$request->selected_requests_id)->get();
            foreach($officeRequests as $officeRequest)
            {
                $officeRequest->isActive = 4;//which means request is deleted by office
                $officeRequest->save();
            }
        }
        return back();
    }

    /*Add new product to list*/
    public function createProduct(Request $request)
    {
        if(!empty($request->product_name)) {
            $storehouses = Storehouse::all();
            $product = new Product;
            $product->name = $request->product_name;
            $product->save();
            foreach ($storehouses as $storehouse) {
                $storehouse->products()->attach($product->id);
            }
        }
        return back();
    }

    /*Edit product name*/
    public function editProduct(Request $request)
    {
        if(!empty($request->new_product_name)) {
            $product = Product::findOrFail($request->product_id);
            $product->name = $request->new_product_name;
            $product->save();
        }
        return back();
    }
}
