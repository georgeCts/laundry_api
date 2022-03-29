<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\UnitType;
use Illuminate\Http\Request;
use App\Models\ServiceCatalog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ServiceCatalogCreateRequest;
use App\Http\Requests\ServiceCatalogUpdateRequest;

class ServicesCatalogController extends Controller
{
    public function index() {
        $lstServices = ServiceCatalog::where('active', true)->orderBy('name_es', 'ASC')->get();
        return view('contents.catalogs.Index', ['lstServices' => $lstServices]);
    }

    public function create() {
        $lstUnitTypes = UnitType::where('active', true)->get();
        return view('contents.catalogs.Create', ['lstUnitTypes' => $lstUnitTypes]);
    }

    public function store(ServiceCatalogCreateRequest $request) {
        try {
            ServiceCatalog::create($request->all());
            Session::flash('success_message', trans('messages.service_catalog_create'));
        } catch(Exception $ex) {           
            return Redirect::back()->withErrors(['error_message' => trans('errors.service_catalog_create')]);
        }

        return Redirect('panel/servicios-catalogo');
    }

    public function edit($id) {
        $objCatalog = ServiceCatalog::find($id);
        if(is_null($objCatalog))
            return Redirect::back();

        $lstUnitTypes = UnitType::where('active', true)->get();
        return view('contents.catalogs.Edit', ['objCatalog' => $objCatalog, 'lstUnitTypes' => $lstUnitTypes]);
    }

    public function update(ServiceCatalogUpdateRequest $request) {
        try {
            ServiceCatalog::where('id', $request->id)->update($request->validated());
            Session::flash('success_message', trans('messages.service_catalog_update'));
        } catch(Exception $ex) {
            dd($ex);
            return Redirect::back()->withErrors(['error_message' => trans('errors.service_catalog_update')]);
        }

        return Redirect('panel/servicios-catalogo');
    }

    public function delete($id) {
        $objCatalog = ServiceCatalog::find($id);
        if(is_null($objCatalog))
            return Redirect::back();

        $objCatalog->active = false;
        $objCatalog->save();

        Session::flash('success_message', trans('messages.service_catalog_delete'));
        return Redirect('panel/servicios-catalogo');
    }
}