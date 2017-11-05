<?php

namespace App\Http\Controllers;

use App\Client;
use App\Export;
use App\Import;
use App\Product;
use App\Remainder;
use App\Returning;
use App\Storehouse;
use App\Request as OfficeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreHouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owner');
    }

    public function getIndex()
    {
        $owner = Auth::user();
        $products = $owner->storehouses->pluck('products')->collapse()->unique();
        $clients = Client::all();
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
        $owner_temp = array();
        $owner_temp['id'] = $owner->id;
        $owner_temp['name'] = $owner->name;
        $stores = array();
        foreach ($owner->storehouses as $storehouse)
        {
            $store = array();
            $store['id'] = $storehouse->id;
            $store['name'] = $storehouse->name;
            array_push($stores,$store);
        }
        $owner_temp['stores'] = $stores;
        array_push($owners,$owner_temp);

        $owners = json_encode($owners);
        $stores = array();
        foreach($owner->storehouses as $storehouse)
        {
            $store = array();
            $store['id'] = $storehouse->id;
            $store['name'] = $storehouse->name;
            $store['owner'] = $storehouse->owner->name;
            array_push($stores,$store);
        }
        $stores = json_encode($stores);
    	return view('storehouse.remainder')->withGoods($goods)->withWhos($whos)->withOwners($owners)->withStores($stores);
    }

    public function getImport()
    {
        $storehouse = Auth::user();
        $imports = array();
        foreach($storehouse->imports as $import)
        {
            $import_temp = array();
            $import_temp['name'] = $import->remainder->product->name;
            $import_temp['number'] = $import->quantity;
            $import_temp['who'] = $import->client->name;
            $import_temp['date'] = Carbon::parse($import->created_at)->format('d.m.Y');
            array_push($imports,$import_temp);
        }
        $imports = json_encode($imports);
        return view('storehouse.import')->withImports($imports);
    }

    public function getExport()
    {
        $storehouse = Auth::user();
        $exports = array();
        foreach($storehouse->exports as $export)
        {
            $export_temp = array();
            $export_temp['id'] = $export->id;
            $export_temp['name'] = $export->remainder->product->name;
            $export_temp['number'] = $export->quantity;
            $export_temp['who'] = $export->client->name;
            $export_temp['date'] = Carbon::parse($export->created_at)->format('d.m.Y');
            if($export->returning()->exists()) {
                $export_temp['return'] = $export->returning->quantity;
                $export_temp['returnDate'] = Carbon::parse($export->returning->created_at)->format('d.m.Y');
            }
            else{
                $export_temp['return'] = false;
                $export_temp['returnDate'] = false;
            }
            array_push($exports,$export_temp);
        }
        $exports = json_encode($exports);
        return view('storehouse.export')->withExports($exports);
    }

    public function productExport(Request $request)
    {
        if(!empty($request->export_product_quantity) && !empty($request->export_client_name))
        {
            $storehouse = Auth::user();
            $product = $storehouse->products()->findOrFail($request->export_product_id);
            $product->remainder->quantity = $product->remainder->quantity - $request->export_product_quantity;
            $product->remainder->save();
            $export = new Export;
            $export->remainder_id = $product->remainder->id;
            if(Client::where('name',$request->import_client_name)->exists()){
                $client = Client::where('name',$request->import_client_name)->get();
                $export->client_id = $client->id;
            }
            else{
                $client = new Client;
                $client->name = $request->import_client_name;
                $client->contacts = "?";//till implementation
                $client->save();
                $export->client_id = $client->id;
            }
            $export->quantity = $request->export_product_quantity;
            $export->fromRequest = false;
            $export->save();
        }
        return back();
    }

    public function productImport(Request $request)
    {
        if(!empty($request->import_product_quantity) && !empty($request->import_client_name)) {
            $storehouse = Auth::user();
            $product = $storehouse->products()->findOrFail($request->import_product_id);
            $product->remainder->quantity = $product->remainder->quantity + $request->import_product_quantity;
            $product->remainder->save();
            $import = new Import;
            $import->remainder_id = $product->remainder->id;
            if(Client::where('name',$request->import_client_name)->exists()){
                $client = Client::where('name',$request->import_client_name)->get();
                $import->client_id = $client->id;
            }
            else{
                $client = new Client;
                $client->name = $request->import_client_name;
                $client->contacts = "?";//till implementation
                $client->save();
                $import->client_id = $client->id;
            }
            $import->quantity = $request->import_product_quantity;
            $import->fromRequest = false;
            $import->save();
        }
        return back();
    }
    /*Export made according to request from office*/
    public function requestExportAccept(Request $request)
    {
        if(!empty($request->selected_requests_id)) {
            $exportRequests = OfficeRequest::whereIn('id',$request->selected_requests_id)->get();
            foreach($exportRequests as $exportRequest)
            {
                $remainder = Remainder::findOrFail($exportRequest->remainder_id);
                $remainder->quantity = $remainder->quantity - $exportRequest->quantity;
                $remainder->save();
                $export = new Export;
                $export->remainder_id = $remainder->id;
                $export->client_id = $exportRequest->client_id;
                $export->quantity = $request->request_export_quantity;
                $export->fromRequest = true;
                $export->save();
                if($exportRequest->quantity == $export->quantity)
                    $exportRequest->isActive = false;
                else
                    $exportRequest->isActive = 3;//which means storehouse changed quantity of request
                $exportRequest->save();
            }
        }
        return back();
    }
    /*Import according to request from office*/
    public function requestImportAccept(Request $request)
    {
        if(!empty($request->selected_requests_id)) {
            $importRequests = OfficeRequest::whereIn('id', $request->selected_requests_id)->get();
            foreach ($importRequests as $importRequest) {
                $remainder = Remainder::findOrFail($importRequest->remainder_id);
                $remainder->quantity = $remainder->quantity + $importRequest->quantity;
                $remainder->save();
                $import = new Import;
                $import->remainder_id = $remainder->id;
                $import->client_id = $importRequest->client_id;
                $import->quantity = $request->request_import_quantity;
                $import->fromRequest = true;
                $import->save();
                if($importRequest->quantity == $import->quantity)
                    $importRequest->isActive = false;
                else
                    $importRequest->isActive = 3;//which means storehouse changed quantity of request
                $importRequest->save();
            }
        }
        return back();
    }

    public function requestReject(Request $request)
    {
        $officeRequests = OfficeRequest::where('id',$request->selected_requests_id)->get();
        foreach($officeRequests as $officeRequest)
        {
            $officeRequest->isActive = 2;//which means Storehouse rejected Office request
            $officeRequest->save();
        }
        return back();
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

    public function returnExport(Request $request)
    {
        if(!empty($request->return_quantity)) {
            $export = Export::findOrFail($request->export_id);
            $export->remainder->quantity = $export->remainder->quantity + $request->return_quantity;
            $export->remainder->save();
            $return = new Returning;
            $return->export_id = $request->export_id;
            $return->quantity = $request->return_quantity;
            $return->save();
        }
        return back();
    }
}
