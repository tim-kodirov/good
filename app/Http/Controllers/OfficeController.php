<?php

namespace App\Http\Controllers;

use App\Client;
use App\Export;
use App\Import;
use App\Product;
use App\Remainder;
use App\Storehouse;
use App\User;
use Carbon\Carbon;
use App\Request as OfficeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:office');
    }

    public function getIndex()
    {
        $products = Product::all();
        $clients = Client::all();
        $users = User::all();
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
                $storehouse_temp = array();
                $storehouse_temp['id'] = $storehouse->id;
                $storehouse_temp['remainder_id'] = $storehouse->remainder->id;
                $storehouse_temp['name'] = $storehouse->name;
                $storehouse_temp['owner'] = $storehouse->owner->name;
                $storehouse_temp['number'] = $storehouse->remainder->quantity;
                $good['totalFull'] = $good['totalFull'] + $storehouse->remainder->quantity;
                $storehouse_temp['requests']['up'] = array();
                $storehouse_temp['requests']['down'] = array();
                $storehouse_temp['requests']['totalUp'] = 0;
                $storehouse_temp['requests']['totalDown'] = 0;
                foreach($storehouse->requests()->where('remainder_id',$storehouse->remainder->id)->get() as $request)
                {
                    if($request->isExport && $request->isActive == 1) {
                        $up = array();
                        $up['id'] = $request->id;
                        $up['who'] = $request->client->name;
                        $up['number'] = $request->quantity;
                        $storehouse_temp['requests']['totalUp'] = $storehouse_temp['requests']['totalUp'] + $request->quantity;
                        $up['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
                        array_push($storehouse_temp['requests']['up'],$up);
                    }
                    elseif(!$request->isExport && $request->isActive == 1) {
                        $down = array();
                        $down['id'] = $request->id;
                        $down['who'] = $request->client->name;
                        $down['number'] = $request->quantity;
                        $storehouse_temp['requests']['totalDown'] = $storehouse_temp['requests']['totalDown'] + $request->quantity;
                        $down['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
                        array_push($storehouse_temp['requests']['down'],$down);
                    }
                }
                $good['total'] = $good['total'] + $storehouse_temp['requests']['totalUp'];
                if(empty($storehouse_temp['requests']['up']) || !isset($storehouse_temp['requests']['up']))
                    $storehouse_temp['requests']['up'] = false;
                if(empty($storehouse_temp['requests']['down']) || !isset($storehouse_temp['requests']['down']))
                    $storehouse_temp['requests']['down'] = false;
                array_push($storehouses,$storehouse_temp);
            }
            $good['total'] = $good['totalFull']-$good['total'];
            $good['stores'] = $storehouses;
            array_push($goods,$good);
        }
        $goods = json_encode($goods);
        $whos = array();
        foreach ($clients as $client)
        {
            array_push($whos,$client->name);
        }
        $whos = json_encode($whos);
        $owners = array();
        foreach ($users as $user)
        {
            $owner = array();
            $owner['id'] = $user->id;
            $owner['name'] = $user->name;
            $stores = array();
            foreach ($user->storehouses as $storehouse)
            {
                $store = array();
                $store['id'] = $storehouse->id;
                $store['name'] = $storehouse->name;
                array_push($stores,$store);
            }
            $owner['stores'] = $stores;
            array_push($owners,$owner);
        }
        $owners = json_encode($owners);
        $storehouses = Storehouse::all();
        $stores = array();
        foreach($storehouses as $storehouse)
        {
            $store = array();
            $store['id'] = $storehouse->id;
            $store['name'] = $storehouse->name;
            $store['owner'] = $storehouse->owner->name;
            array_push($stores,$store);
        }
        $stores = json_encode($stores);
    	return view('office.remainder')->withGoods($goods)->withWhos($whos)->withOwners($owners)->withStores($stores);
    }

    public function getImport()
    {
        $imports = Import::all();
        $ports = array();
        foreach($imports as $import)
        {
            $port = array();
            $port['name'] = $import->remainder->product->name;
            $store = array();
            $store['id'] = $import->remainder->storehouse->id;
            $store['name'] = $import->remainder->storehouse->name;
            $store['owner'] = $import->remainder->storehouse->owner->name;
            $port['store'] = $store;
            $port['number'] = $import->quantity;
            $port['who'] = $import->client->name;
            $port['date'] = Carbon::parse($import->created_at)->format('d.m.Y');
            array_push($ports,$port);
        }
        $imports = json_encode($ports);
        $users = User::all();
        $owners = array();
        foreach ($users as $user)
        {
            $owner = array();
            $owner['id'] = $user->id;
            $owner['name'] = $user->name;
            $stores = array();
            foreach ($user->storehouses as $storehouse)
            {
                $store = array();
                $store['id'] = $storehouse->id;
                $store['name'] = $storehouse->name;
                array_push($stores,$store);
            }
            $owner['stores'] = $stores;
            array_push($owners,$owner);
        }
        $owners = json_encode($owners);
        $storehouses = Storehouse::all();
        $stores = array();
        foreach($storehouses as $storehouse)
        {
            $store = array();
            $store['id'] = $storehouse->id;
            $store['name'] = $storehouse->name;
            $store['owner'] = $storehouse->owner->name;
            array_push($stores,$store);
        }
        $stores = json_encode($stores);
        return view('office.import')->withImports($imports)->withStores($stores)->withOwners($owners);
    }

    public function getExport()
    {
        $exports = Export::all();
        $ports = array();
        foreach($exports as $export)
        {
            $port = array();
            $port['id'] = $export->id;
            $port['name'] = $export->remainder->product->name;
            $store = array();
            $store['id'] = $export->remainder->storehouse->id;
            $store['name'] = $export->remainder->storehouse->name;
            $store['owner'] = $export->remainder->storehouse->owner->name;
            $port['store'] = $store;
            $port['number'] = $export->quantity;
            $port['who'] = $export->client->name;
            $port['date'] = Carbon::parse($export->created_at)->format('d.m.Y');
            $returns = array();
            foreach ($export->returns as $return)
            {
                $returning = array();
                $returning['number'] = $return->quantity;
                $returning['date'] = Carbon::parse($return->created_at)->format('d.m.Y');
                array_push($returns,$returning);
            }
            $port['returns'] = $returns;
            if(!$export->returns->exists()){
                $port['returns'] = false;
            }
            array_push($ports,$port);
        }
        $exports = json_encode($ports);
        $users = User::all();
        $owners = array();
        foreach ($users as $user)
        {
            $owner = array();
            $owner['id'] = $user->id;
            $owner['name'] = $user->name;
            $stores = array();
            foreach ($user->storehouses as $storehouse)
            {
                $store = array();
                $store['id'] = $storehouse->id;
                $store['name'] = $storehouse->name;
                array_push($stores,$store);
            }
            $owner['stores'] = $stores;
            array_push($owners,$owner);
        }
        $owners = json_encode($owners);
        $storehouses = Storehouse::all();
        $stores = array();
        foreach($storehouses as $storehouse)
        {
            $store = array();
            $store['id'] = $storehouse->id;
            $store['name'] = $storehouse->name;
            $store['owner'] = $storehouse->owner->name;
            array_push($stores,$store);
        }
        $stores = json_encode($stores);
        return view('office.export')->withExports($exports)->withStores($stores)->withOwners($owners);
    }

    public function createRequest(Request $request)
    {
        if(!empty($request->request_quantity) && !empty($request->client_name)){
            if(Remainder::where('id',$request->remainder_id)->exists()){
                $officeRequest = new OfficeRequest;
                $officeRequest->remainder_id = $request->remainder_id;
                if(Client::where('name',$request->client_name)->exists()){
                    $client = Client::where('name',$request->client_name)->first();
                    $officeRequest->client_id = $client->id;
                }
                else{
                    $client = new Client;
                    $client->name = $request->client_name;
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
                if(!empty($request->clients_name[$officeRequest->id]) && !empty($request->requests_quantity[$officeRequest->id])){
                    $officeRequest->quantity = $request->requests_quantity[$officeRequest->id];
                    if(Client::where('name',$request->clients_name[$officeRequest->id])->exists()){
                        $client = Client::where('name',$request->clients_name[$officeRequest->id])->first();
                        $officeRequest->client_id = $client->id;
                    }
                    else{
                        $client = new Client;
                        $client->name = $request->clients_name[$officeRequest->id];
                        $client->save();
                        $officeRequest->client_id = $client->id;
                    }
                    $officeRequest->save();
                }
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
        if(!empty($request->product_name) && !empty($request->product_store_name)) {
            $storehouse = Storehouse::where('name', $request->product_store_name)->first();
            $product = new Product;
            $product->name = $request->product_name;
            $product->save();
            $storehouse->products()->attach($product->id);
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

    public function createStore(Request $request)
    {
        if(!empty($request->storehouse_name)) {
            $storehouse = new Storehouse;
            $storehouse->name = $request->storehouse_name;
            $user = User::where('name',$request->storehouse_owner)->first();
            $storehouse->user_id = $user->id;
            $storehouse->save();
        }
        return back();
    }

    public function createOwner(Request $request)
    {
        if(!empty($request->owner_username) && !empty($request->owner_password) && !empty($request->owner_name)) {
            $user = new User;
            $user->name = $request->owner_name;
            $user->username = $request->owner_username;
            $user->password = Hash::make($request->owner_password);
            $user->save();
        }
        return back();
    }
}
