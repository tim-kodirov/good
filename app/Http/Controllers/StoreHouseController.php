<?php

namespace App\Http\Controllers;

use App\Client;
use App\Export;
use App\Import;
use App\Product;
use App\Remainder;
use App\Storehouse;
use App\Request as OfficeRequest;
use Carbon\Carbon;
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
        $clients = Client::all();
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
                if($request->isExport && $request->isActive == 1)
                {
                    $up = array();
                    $up['id'] = $request->id;
                    $up['who'] = $request->client->name;
                    $up['number'] = $request->quantity;
                    $up['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
                    array_push($good['requests']['up'],$up);
                }
                elseif(!$request->isExport && $request->isActive == 1)
                {
                    $down = array();
                    $down['id'] = $request->id;
                    $down['who'] = $request->client->name;
                    $down['number'] = $request->quantity;
                    $down['date'] = Carbon::parse($request->created_at)->format('d.m.Y');
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
        $clients->toJson();
    	return view('storehouse.remainder')->withGoods($goods)->withClients($clients);
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
        if(!empty($request->import_product_quantity) && !empty($request->import_client_name))
        {
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
        if(!empty($request->selected_requests_id))
        {
            $exportRequests = OfficeRequest::whereIn('id',$request->selected_requests_id)->get();
            foreach($exportRequests as $exportRequest)
            {
                $remainder = Remainder::findOrFail($exportRequest->remainder_id);
                $remainder->quantity = $remainder->quantity - $exportRequest->quantity;
                $remainder->save();
                $export = new Export;
                $export->remainder_id = $remainder->id;
                $export->client_id = $exportRequest->client_id;
                $export->quantity = $exportRequest->quantity;
                $export->fromRequest = true;
                $export->save();
                $exportRequest->isActive = false;
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
                $import->quantity = $importRequest->quantity;
                $import->fromRequest = true;
                $import->save();
                $importRequest->isActive = false;
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

    public function returnExport(Request $request, $id)
    {

    }
}
