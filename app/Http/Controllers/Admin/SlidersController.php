<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Library\Encryption;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;

use App\Slider;

class SlidersController extends Controller
{
    public function index() {
        $lstSliders = Slider::where('deleted', 0)->get();

        return view('panel.contents.sliders.Index', ['lstSliders' => $lstSliders]);
    }

    public function create() {
        return view('panel.contents.sliders.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/sliders/slider-crear', 'panel/sliders');

        if($request->file('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '_image_slider.' . $extension;
            $url        = '/slider/' . $fileName;

            try {
                if($request->image->storeAs('slider', $fileName)) {
                    $objSlider                  = new Slider();
                    $objSlider->title           = $request->title;
                    $objSlider->body            = $request->body;
                    $objSlider->status          = $request->status;
                    $objSlider->url_redirect    = $request->url_redirect;
                    $objSlider->file            = $url;
                    $objSlider->save();

                    $objReturn->setResult(true, Messages::SLIDERS_CREATE_TITLE, Messages::SLIDERS_CREATE_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::SLIDERS_CREATE_02_TITLE, Errors::SLIDERS_CREATE_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::SLIDERS_CREATE_01_TITLE, Errors::SLIDERS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return     = redirect('panel/sliders');
        $objSlider  = Slider::where('id', $id)->first();

        if($objSlider != null) {
            $return = view('panel.contents.sliders.Edit', ['objSlider' => $objSlider]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn = new ActionReturn('panel/sliders/slider-editar/'.$request['hddIdSlider'], 'panel/sliders');
        $objSlider = Slider::where('id', $request['hddIdSlider'])->first();

        if($objSlider != null) {
            try {
                $objSlider->title               = $request->title;
                $objSlider->body            = $request->body;
                $objSlider->status          = $request->status;
                $objSlider->url_redirect    = $request->url_redirect;

                if($request->file('image')) {
                    Storage::delete($objSlider->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_image_slider.' . $extension;
                    $url        = '/slider/' . $fileName;

                    $request->image->storeAs('slider', $fileName);
                    $objSlider->file = $url;
                }

                if($objSlider->save()) {
                    $objReturn->setResult(true, Messages::SLIDERS_EDIT_TITLE, Messages::SLIDERS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::SLIDERS_EDIT_02_TITLE, Errors::SLIDERS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::SLIDERS_EDIT_01_TITLE, Errors::SLIDERS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
