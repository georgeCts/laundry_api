<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\PrestigeBrand;
use Storage;

class PrestigeBrandsController extends Controller
{
    public function index() {
        $lstBrands = PrestigeBrand::where('deleted', 0)->get();
        return view('panel.contents.prestige-brands.Index', ['lstBrands' => $lstBrands]);
    }

    public function create() {
        return view('panel.contents.prestige-brands.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/marcas-prestigio/prestigio-crear', 'panel/marcas-prestigio');

        if($request->file('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '_image_prov.' . $extension;
            $url        = '/proveedores/' . $fileName;

            try {
                if($request->image->storeAs('proveedores', $fileName)) {
                    $objBrand           = new PrestigeBrand();
                    $objBrand->name     = $request->name;
                    $objBrand->status   = $request->status;
                    $objBrand->file     = $url;
                    $objBrand->save();

                    $objReturn->setResult(true, Messages::BRANDS_CREATE_TITLE, Messages::BRANDS_CREATE_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::BRANDS_CREATE_01_TITLE, Errors::BRANDS_CREATE_01_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::BRANDS_CREATE_01_TITLE, Errors::BRANDS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return     = redirect('panel/marcas-prestigio');
        $objBrand   = PrestigeBrand::where('id', $id)->first();

        if($objBrand != null) {
            $return = view('panel.contents.prestige-brands.Edit', ['objBrand' => $objBrand]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/marcas-prestigio/prestigio-editar/'.$request['hddIdBrand'], 'panel/marcas-prestigio');
        $objBrand   = PrestigeBrand::where('id', $request['hddIdBrand'])->first();

        if($objBrand != null) {
            try {
                $objBrand->name     = $request->name;
                $objBrand->status   = $request->status;

                if($request->file('image')) {
                    Storage::delete($objBrand->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_image_prov.' . $extension;
                    $url        = '/proveedores/' . $fileName;

                    $request->image->storeAs('proveedores', $fileName);

                    $objBrand->file = $url;
                }

                if($objBrand->save()) {
                    $objReturn->setResult(true, Messages::BRANDS_EDIT_TITLE, Messages::BRANDS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::BRANDS_EDIT_02_TITLE, Errors::BRANDS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::BRANDS_EDIT_01_TITLE, Errors::BRANDS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
