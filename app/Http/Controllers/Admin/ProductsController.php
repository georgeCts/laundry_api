<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidator;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\Services\ImportProduct;
use App\Product;
use App\ProductYear;
use App\ProductEngine;
use App\Brand;
use App\BrandModel;
use Storage;

class ProductsController extends Controller
{
    protected $validaciones;
    protected $importar;

    public function __construct(ProductValidator $validaciones, ImportProduct $importar) {
        $this->validaciones = $validaciones;
        $this->importar     = $importar;
    }

    public function index() {
        $lstProducts = Product::where('deleted', false)->orderBy('created_at', 'DESC')->get();
        return view('panel.contents.products.Index', ['lstProducts' => $lstProducts]);
    }

    public function create() {
        $lstBrands  = Brand::where('deleted', false)->orderBy('name', 'ASC')->get();
        $lstYears   = ProductYear::where('deleted', false)->orderBy('year', 'ASC')->get();
        $lstEngines = ProductEngine::where('deleted', false)->orderBy('engine', 'ASC')->get();
        return view('panel.contents.products.Create', ['lstBrands' => $lstBrands, 'lstYears' => $lstYears, 'lstEngines' => $lstEngines]);
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/productos/producto-crear', 'panel/productos');

        if($request->file('image')) {
            $product = Product::where('part_number', $request->part_number)->first();

            if($product == null) {
                $file       = $request->file('image');
                $extension  = $file->getClientOriginalExtension();
                $fileName   = time() . '_image_prod.' . $extension;
                $url        = '/productos/' . $fileName;
    
                try {
                    if($request->image->storeAs('productos', $fileName)) {
                        $objProduct                     = new Product();
                        $objProduct->name               = $request->name;
                        $objProduct->description        = $request->description;
                        $objProduct->part_number        = $request->part_number;
                        $objProduct->brand_id           = $request->brand_id != 0 ? $request->brand_id : null;
                        $objProduct->brand_model_id     = $request->brand_model_id != 0 ? $request->brand_model_id : null;
                        $objProduct->product_year_id    = $request->product_year_id != 0 ? $request->product_year_id : null;
                        $objProduct->product_engine_id  = $request->product_engine_id != 0 ? $request->product_engine_id : null;
                        $objProduct->file               = $url;
                        $objProduct->save();
    
                        $objReturn->setResult(true, Messages::PRODUCTS_CREATE_TITLE, Messages::PRODUCTS_CREATE_MESSAGE);
                    } else {
                        $objReturn->setResult(false, Errors::PRODUCTS_CREATE_03_TITLE, Errors::PRODUCTS_CREATE_03_MESSAGE);
                    }
                } catch(Exception $exception) {
                    $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
                }
            } else {
                $objReturn->setResult(false, Errors::PRODUCTS_CREATE_02_TITLE, Errors::PRODUCTS_CREATE_02_MESSAGE);
            }
        } else {
            $objReturn->setResult(false, Errors::PRODUCTS_CREATE_01_TITLE, Errors::PRODUCTS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return     = redirect('panel/productos');
        $objProduct   = Product::where('id', $id)->first();

        if($objProduct != null) {
            $return = view('panel.contents.products.Edit', ['objProduct' => $objProduct]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/productos/producto-editar/'.$request['hddIdProduct'], 'panel/productos');
        $objProduct   = Product::where('id', $request['hddIdProduct'])->first();

        if($objProduct != null) {
            $product    = Product::where('id', '!=', $request['hddIdProduct'])
                            ->where('part_number', $request->part_number)
                            ->first();

            if($product == null) {
                try {
                    $objProduct->name               = $request->name;
                    $objProduct->description        = $request->description;
                    $objProduct->part_number        = $request->part_number;
                    $objProduct->brand_id           = $request->brand_id != 0 ? $request->brand_id : null;
                    $objProduct->brand_model_id     = $request->brand_model_id != 0 ? $request->brand_model_id : null;
                    $objProduct->product_year_id    = $request->product_year_id != 0 ? $request->product_year_id : null;
                    $objProduct->product_engine_id  = $request->product_engine_id != 0 ? $request->product_engine_id : null;
                    
    
                    if($request->file('image')) {
                        Storage::delete($objProduct->file);
    
                        $file       = $request->file('image');
                        $extension  = $file->getClientOriginalExtension();
                        $fileName   = time() . '_image_prod.' . $extension;
                        $url        = '/productos/' . $fileName;
    
                        $request->image->storeAs('productos', $fileName);
    
                        $objProduct->file = $url;
                    }
    
                    if($objProduct->save()) {
                        $objReturn->setResult(true, Messages::PRODUCTS_EDIT_TITLE, Messages::PRODUCTS_EDIT_MESSAGE);
                    } else {
                        $objReturn->setResult(false, Errors::PRODUCTS_EDIT_03_TITLE, Errors::PRODUCTS_EDIT_03_MESSAGE);
                    }
                } catch(Exception $exception) {
                    $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
                }
            } else {
                $objReturn->setResult(false, Errors::PRODUCTS_EDIT_02_TITLE, Errors::PRODUCTS_EDIT_02_MESSAGE);
            }
        } else {
            $objReturn->setResult(false, Errors::PRODUCTS_EDIT_01_TITLE, Errors::PRODUCTS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function import(Request $request){
        $validacion  = $this->validaciones->importData($request);
        if( $validacion  !== true)
            return response()->json(['error'=> $validacion->original], 403);

        $respuesta = $this->importar->importProducts($request);

        if($respuesta['response'] == true) {
            if(sizeof($respuesta['errors']) > 0) {
                return response()->json(['message' => 'Algunos datos no se pudieron guardar, probablemente ya se encuentren registrados.', 'type' => 'warning'], 202);
            } else {
                return response()->json(['message' => 'Datos guardados correctamente.', 'type' => 'success'], 202);
            }
        }
    }

    public function loadCollection(Request $request) {
        $lstBrands  = Brand::where('deleted', false)->orderBy('name', 'ASC')->get();
        $lstYears   = ProductYear::where('deleted', false)->orderBy('year', 'ASC')->get();
        $lstEngines = ProductEngine::where('deleted', false)->orderBy('engine', 'ASC')->get();

        return response()->json([
            "lstBrands"     => $lstBrands,
            "lstYears"      => $lstYears,
            "lstEngines"    => $lstEngines,
        ], 200);
    }

    public function loadModels(Request $request) {
        $lstModels = BrandModel::where('brand_id', $request->id)->where('deleted', false)->orderBy('name', 'ASC')->get();

        return response()->json($lstModels, 200);
    }

    public function loadProduct(Request $request) {
        $objProduct   = Product::where('id', $request->id)->first();
        return response()->json($objProduct, 200);
    }
}
