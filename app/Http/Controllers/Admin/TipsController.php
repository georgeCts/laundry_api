<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Messages;
use App\Library\Errors;
use App\Library\FormatValidation;
use App\Library\Returns\ActionReturn;
use App\Library\Returns\AjaxReturn;
use App\Tip;
use Storage;

class TipsController extends Controller
{
    public function index() {
        $lstTips = Tip::where('deleted', 0)->orderBy('created_at', 'DESC')->get();
        return view('panel.contents.expert-tips.Index', ['lstTips' => $lstTips]);
    }

    public function create() {
        return view('panel.contents.expert-tips.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/tips/tip-crear', 'panel/tips');

        if($request->file('image')) {
            $file       = $request->file('image');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = time() . '_image_tip.' . $extension;
            $url        = '/tips/' . $fileName;

            try {
                if($request->image->storeAs('tips', $fileName)) {
                    $objTip           = new Tip();
                    $objTip->title    = $request->title;
                    $objTip->body     = $request->body;
                    $objTip->status   = $request->status;
                    $objTip->file     = $url;
                    $objTip->save();

                    $objReturn->setResult(true, Messages::TIPS_CREATE_TITLE, Messages::TIPS_CREATE_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::TIPS_CREATE_02_TITLE, Errors::TIPS_CREATE_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::TIPS_CREATE_01_TITLE, Errors::TIPS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return = redirect('panel/tips');
        $objTip = Tip::where('id', $id)->first();

        if($objTip != null) {
            $return = view('panel.contents.expert-tips.Edit', ['objTip' => $objTip]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/tips/tip-editar/'.$request['hddIdTip'], 'panel/tips');
        $objTip     = Tip::where('id', $request['hddIdTip'])->first();

        if($objTip != null) {
            try {
                $objTip->title  = $request->title;
                $objTip->body   = $request->body;
                $objTip->status = $request->status;

                if($request->file('image')) {
                    if($objTip->file != null)
                        Storage::delete($objTip->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_image_tip.' . $extension;
                    $url        = '/tips/' . $fileName;

                    $request->image->storeAs('tips', $fileName);

                    $objTip->file = $url;
                }

                if($objTip->save()) {
                    $objReturn->setResult(true, Messages::TIPS_EDIT_TITLE, Messages::TIPS_EDIT_MESSAGE);
                } else {
                    $objReturn->setResult(false, Errors::TIPS_EDIT_02_TITLE, Errors::TIPS_EDIT_02_MESSAGE);
                }
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::TIPS_EDIT_01_TITLE, Errors::TIPS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
