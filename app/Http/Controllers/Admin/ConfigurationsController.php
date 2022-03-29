<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\UnitType;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ServiceCatalog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ConfigurationUpdateRequest;
use App\Http\Requests\ServiceCatalogCreateRequest;
use App\Http\Requests\ServiceCatalogUpdateRequest;

class ConfigurationsController extends Controller
{
    public function index() {
        $lstConfigurations = Configuration::where('active', true)->orderBy('description', 'ASC')->get();
        return view('contents.configurations.Index', ['lstConfigurations' => $lstConfigurations]);
    }

    public function edit($id) {
        $objConfiguration = Configuration::find($id);
        if(is_null($objConfiguration))
            return Redirect::back();

        return view('contents.configurations.Edit', ['objConfiguration' => $objConfiguration]);
    }

    public function update(ConfigurationUpdateRequest $request) {
        try {
            Configuration::where('id', $request->id)->update($request->validated());
            Session::flash('success_message', trans('messages.configurations_update'));
        } catch(Exception $ex) {
            dd($ex);
            return Redirect::back()->withErrors(['error_message' => trans('errors.configurations_update')]);
        }

        return Redirect('panel/configuraciones');
    }
}