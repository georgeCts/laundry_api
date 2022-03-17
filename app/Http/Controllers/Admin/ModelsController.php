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
use App\BrandModel;
use Redirect;

class ModelsController extends Controller
{
    public function index($id) {
        $objBrand = Brand::where('id', $id)->where('deleted', 0)->first();

        if(!is_null($objBrand)) {
            $lstModels = BrandModel::where('brand_id', $id)->where('deleted', 0)->get();
            return view('panel.contents.brands.models.Index', ['objBrand' => $objBrand, 'lstModels' => $lstModels]);
        }

        return Redirect('/panel/brands');
    }

    public function create($id) {
        $objBrand = Brand::where('id', $id)->where('deleted', 0)->first();
        return view('panel.contents.brands.models.Create', ['objBrand' => $objBrand]);
    }

    public function store(Request $request) {
        $objReturn  = new ActionReturn('panel/brands/'.$request->hddIdBrand.'/models/crear', 'panel/brands/'.$request->hddIdBrand.'/models');
        $objBrand   = Brand::where('id', $request->hddIdBrand)->where('deleted', 0)->first();

        if($objBrand != null) {
            try {
                $objModel           = new BrandModel();
                $objModel->brand_id = $request->hddIdBrand;
                $objModel->name     = strtoupper($request['txtName']);
                $objModel->deleted  = 0;
    
                if($objModel->save()) {
                    $objReturn->setResult(true, Messages::MODELS_CREATE_TITLE, Messages::MODELS_CREATE_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::MODELS_CREATE_02_TITLE, Errors::MODELS_CREATE_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::MODELS_CREATE_01_TITLE, Errors::MODELS_CREATE_01_MESSAGE);
        }
        

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return = redirect('panel/brands/');

        $objModel = BrandModel::where('id', $id)->where('deleted', 0)->first();

        if($objModel != null) {
            $return = view('panel.contents.brands.models.Edit', ['objModel' => $objModel]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/brands/models/model-editar/'.$request->hddIdModel, 'panel/brands/'.$request->hddIdBrand.'/models');
        $objModel   = BrandModel::where('id', $request->hddIdModel)->first();

        if($objModel != null) {
            $objModel->name = $request['txtName'];
            try {
                if($objModel->save()) {
                    $objReturn->setResult(true, Messages::MODELS_EDIT_TITLE, Messages::MODELS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::MODELS_EDIT_02_TITLE, Errors::MODELS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::MODELS_EDIT_01_TITLE, Errors::MODELS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
