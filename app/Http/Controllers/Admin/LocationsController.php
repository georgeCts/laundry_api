<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\Location;
use View;

class LocationsController extends Controller
{
    public function index() {
        $lstLocations = Location::where('deleted', false)->orderBy('id', 'DESC')->get();
        return View::make('panel.contents.locations.Index', ['lstLocations' => $lstLocations]);
    }

    public function create() {
        return View::make('panel.contents.locations.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/sucursales/sucursal-crear', 'panel/sucursales');

        try {
            $objLocation                = new Location();
            $objLocation->name          = $request->name;
            $objLocation->address       = $request->address;
            $objLocation->latitude      = $request->latitude;
            $objLocation->longitude     = $request->longitude;
            $objLocation->phone         = $request->phone;
            $objLocation->whatsapp1     = $request->whatsapp1;
            $objLocation->whatsapp2     = $request->whatsapp2;

            if($objLocation->save()) {
                $objReturn->setResult(true, Messages::LOCATIONS_CREATE_TITLE, Messages::LOCATIONS_CREATE_MESSAGE);
            } else {
                $objReturn->setResult(false, Errors::LOCATIONS_CREATE_01_TITLE, Errors::LOCATIONS_CREATE_01_MESSAGE);
            }
        } catch(Exception $exception) {
            $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $objLocation = Location::find($id);
        return View::make('panel.contents.locations.Edit', ['objLocation' => $objLocation]);
    }

    public function update(Request $request) {
        $objReturn = new ActionReturn('panel/sucursales/sucursal-editar/'.$request['hddIdLocation'], 'panel/sucursales');

        $objLocation = Location::where('id', $request['hddIdLocation'])->first();

        if($objLocation != null) {
            try {
                $objLocation->name          = $request->name;
                $objLocation->address       = $request->address;
                $objLocation->latitude      = $request->latitude;
                $objLocation->longitude     = $request->longitude;
                $objLocation->phone         = $request->phone;
                $objLocation->whatsapp1     = $request->whatsapp1;
                $objLocation->whatsapp2     = $request->whatsapp2;

                if($objLocation->save()) {
                    $objReturn->setResult(true, Messages::LOCATIONS_EDIT_TITLE, Messages::LOCATIONS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::LOCATIONS_EDIT_02_TITLE, Errors::LOCATIONS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::LOCATIONS_EDIT_01_TITLE, Errors::LOCATIONS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
