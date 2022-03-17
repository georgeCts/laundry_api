<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\Promotion;
use Storage;

class PromotionsController extends Controller
{
    public function index() {
        $lstPromotions = Promotion::where('deleted', 0)->orderBy('created_at', 'DESC')->get();
        return view('panel.contents.promotions.Index', ['lstPromotions' => $lstPromotions]);
    }

    public function create() {
        return view('panel.contents.promotions.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/promociones/promocion-crear', 'panel/promociones');

        if($request->file('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '_image_prom.' . $extension;
            $url        = '/promociones/' . $fileName;

            try {
                if($request->image->storeAs('promociones', $fileName)) {
                    $objPromotion               = new Promotion();
                    $objPromotion->title        = $request->title;
                    $objPromotion->body         = $request->body;
                    $objPromotion->status       = $request->status;
                    $objPromotion->is_promotion = $request->is_promotion == "true" ? 1 : 0;
                    $objPromotion->file         = $url;
                    $objPromotion->save();

                    $objReturn->setResult(true, Messages::PROMOTIONS_CREATE_TITLE, Messages::PROMOTIONS_CREATE_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::PROMOTIONS_CREATE_02_TITLE, Errors::PROMOTIONS_CREATE_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::PROMOTIONS_CREATE_01_TITLE, Errors::PROMOTIONS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return = redirect('panel/promociones');
        $objPromotion = Promotion::where('id', $id)->first();

        if($objPromotion != null) {
            $return = view('panel.contents.promotions.Edit', ['objPromotion' => $objPromotion]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn      = new ActionReturn('panel/promociones/promocion-editar/'.$request['hddIdPromotion'], 'panel/promociones');
        $objPromotion   = Promotion::where('id', $request->hddIdPromotion)->first();

        if($objPromotion != null) {
            try {
                $objPromotion->title        = $request->title;
                $objPromotion->body         = $request->body;
                $objPromotion->status       = $request->status;
                $objPromotion->is_promotion = $request->is_promotion == "true" ? 1 : 0;

                if($request->file('image')) {
                    Storage::delete($objPromotion->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_image_prom.' . $extension;
                    $url        = '/promociones/' . $fileName;

                    $request->image->storeAs('promociones', $fileName);

                    $objPromotion->file = $url;
                }

                if($objPromotion->save()) {
                    $objReturn->setResult(true, Messages::PROMOTIONS_EDIT_TITLE, Messages::PROMOTIONS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::PROMOTIONS_EDIT_02_TITLE, Errors::PROMOTIONS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::PROMOTIONS_EDIT_01_TITLE, Errors::PROMOTIONS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
