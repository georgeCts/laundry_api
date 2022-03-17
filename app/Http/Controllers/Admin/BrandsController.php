<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\Brand;

class BrandsController extends Controller
{
    public function index() {
        $lstBrands = Brand::where('deleted', 0)->get();

        return view('panel.contents.brands.Index', ['lstBrands' => $lstBrands]);
    }

    public function create() {
        return view('panel.contents.brands.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/brands/brand-crear', 'panel/brands');

        $objBrand = new Brand();
        $objBrand->name        = $request['txtName'];

        try {
            if($objBrand->save()) {
                $objReturn->setResult(true, Messages::BRANDS_CREATE_TITLE, Messages::BRANDS_CREATE_MESSAGE);
            } else {
                $objReturn->setResult(false, Errors::BRANDS_CREATE_01_TITLE, Errors::BRANDS_CREATE_01_MESSAGE);
            }
        } catch(Exception $exception) {
            $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {

        $return = redirect('panel/brands');

        $objBrand = Brand::where('id', $id)->first();

        if($objBrand != null) {
            $return = view('panel.contents.brands.Edit', ['objBrand' => $objBrand]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn = new ActionReturn('panel/brands/brand-editar/'.$request['hddIdBrand'], 'panel/brands');

        $objBrand = Brand::where('id', $request['hddIdBrand'])->first();

        if($objBrand != null) {
            $objBrand->name        = $request['txtName'];

            try {
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
