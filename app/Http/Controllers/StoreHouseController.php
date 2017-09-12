<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Remainder;
use App\Export;
use App\Import;
use App\Request as OfficeRequest;

class StoreHouseController extends Controller
{

    public function getIndex()
    {
        $remainders = Remainder::all();
        $goods = array();
        $good = array();
        foreach($remainders as $remainder)
        {
            $good['name'] = $remainder->name;
            $good['number'] = $remainder->quantity;
            foreach($remainder->requests() as $request)
            {
                if($request->isExport && $request->isActive)
                {
                    $good['requests']['up']['who'] = $request->who;
                    $good['requests']['up']['number'] = $request->quantity;
                    $good['requests']['up']['date'] = $request->created_at;
                }
                elseif(!$request->isExport && $request->isActive)
                {
                    $good['requests']['down']['who'] = $request->who;
                    $good['requests']['down']['number'] = $request->quantity;
                    $good['requests']['down']['date'] = $request->created_at;
                }
            }
            if(empty($good['requests']['up']) || isset($good['requests']['up']))
                $good['requests']['up'] = false;
            if(empty($good['requests']['down']) || isset($good['requests']['down']))
                $good['requests']['down'] = false;
            array_push($goods,$good);
        }
//        dd($goods);
        $goods = json_encode($goods);

    	return view('storehouse.remainder')->withGoods($goods);
    }

    public function getImport()
    {
        $imports = Import::all();
    	return view('storehouse.import')->withImports($imports);
    }

    public function getExport()
    {
        $exports = Export::all();
    	return view('storehouse.export')->withExports($exports);
    }

    public function directExport(Request $request, $id)
    {
        $product = Remainder::findOrFail($id);
        $export = new Export;
        $export->product_id = $product->id;
        $export->toWhom = $request->toWhom;
        $export->quantity = $request->export_quantityByStoreHouse;
        $export->fromRequest = false;
        $export->save();
    }

    public function directImport(Request $request, $id)
    {
        $product = Remainder::findOrFail($id);
        $import = new Import;
        $import->product_id = $product->id;
        $import->fromWho = $request->fromWho;
        $import->quantity = $request->import_quantityByStoreHouse;
        $import->fromRequest = false;
        $import->save();
    }
    /*Export made according to request from office*/
    public function indirectExport(Request $request, $id)
    {
        $officeRequest = OfficeRequest::findOrFail($id);
        $export = new Export;
        $export->product_id = $officeRequest->product_id;
        $export->toWhom = $officeRequest->who;
        $export->quantity = $request->export_quantityByOffice;//StoreHouse can change quantity of exporting products
        $export->fromRequest = true;
        $export->save();
    }
    /*Import according to request from office*/
    public function indirectImport(Request $request, $id)
    {
        $officeRequest = OfficeRequest::findOrFail($id);
        $import = new Import;
        $import->product_id = $officeRequest->product_id;
        $import->fromWho = $officeRequest->who;
        $import->quantity = $request->import_quantityByOffice;//StoreHouse can change quantity of importing products
        $import->fromRequest = true;
        $import->save();
    }
    /*Add new product to list*/
    public function createProduct(Request $request)
    {
        $product = new Remainder;
        $product->name = $request->product_name;
        $product->save();
        return back()->withInput();
    }

    public function returnExport(Request $request, $id)
    {
        $export = Export::findOrFail($id);
        $export->return = true;
        $export->return_quantity = $request->return_quantity;
        $export->product()->quantity+=$request->return_quantity;
        $export->save();
    }
}
