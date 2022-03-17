<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Category;
use App\Library\Errors;
use App\Library\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Returns\ActionReturn;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index() {
        $lstCategories = Category::where('deleted', 0)->orderBy('created_at', 'DESC')->get();
        return view('panel.contents.categories.Index', ['lstCategories' => $lstCategories]);
    }

    public function create() {
        return view('panel.contents.categories.Create');
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/categorias/categoria-crear', 'panel/categorias');

        $objCategory = Category::where('slug', $request->slug)->first();

        if(!is_null($objCategory)) {
            $objReturn->setResult(false, Errors::CATEGORIES_CREATE_01_TITLE, Errors::CATEGORIES_CREATE_01_MESSAGE);
            return $objReturn->getRedirectPath();
        }

        if($request->file('image')) {
                $file       = $request->file('image');
                $extension  = $file->getClientOriginalExtension();
                $fileName   = time() . '_img_categoria.' . $extension;
                $url        = '/catalogos/' . $fileName;

                try {
                    if($request->image->storeAs('catalogos', $fileName)) {
                        $objCategory            = new Category();
                        $objCategory->name      = $request->name;
                        $objCategory->slug      = $request->slug;
                        $objCategory->file      = $url;
                        $objCategory->save();
    
                        $objReturn->setResult(true, Messages::CATEGORIES_CREATE_TITLE, Messages::CATEGORIES_CREATE_MESSAGE);
                    } else {
                        $objReturn->setResult(false, Errors::CATEGORIES_CREATE_03_TITLE, Errors::CATEGORIES_CREATE_03_MESSAGE);
                    }
                } catch(Exception $exception) {
                    $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
                }
        } else {
            $objReturn->setResult(false, Errors::CATEGORIES_CREATE_02_TITLE, Errors::CATEGORIES_CREATE_02_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return = redirect('panel/categorias');
        $objCategory = Category::where('id', $id)->where('deleted', 0)->first();

        if($objCategory != null)
            $return = view('panel.contents.categories.Edit', ['objCategory' => $objCategory]);

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/categorias/categoria-editar/'.$request->hddIdCategory, 'panel/categorias');
        $objCategory   = Category::where('id', $request->hddIdCategory)->first();

        if($objCategory != null) {
            try {
                $objCategory->name        = $request->name;
                $objCategory->slug        = $request->slug;

                if($request->file('image')) {
                    Storage::delete($objCategory->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_img_categoria.' . $extension;
                    $url        = '/catalogos/' . $fileName;

                    $request->image->storeAs('catalogos', $fileName);
                    $objCategory->file = $url;
                }

                if($objCategory->save())
                    $objReturn->setResult(true, Messages::CATEGORIES_EDIT_TITLE, Messages::CATEGORIES_EDIT_MESSAGE);
                else
                    $objReturn->setResult(false, Errors::CATEGORIES_EDIT_02_TITLE, Errors::CATEGORIES_EDIT_02_MESSAGE);
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::CATEGORIES_EDIT_01_TITLE, Errors::CATEGORIES_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function delete($id) {
        $objReturn  = new ActionReturn('panel/categorias', 'panel/categorias');
        $objCategory = Category::where('id', $id)->where('deleted', 0)->first();

        if($objCategory != null) {
            $objCategory->deleted = 1;
            $objCategory->save();

            $objReturn->setResult(true, Messages::CATEGORIES_DELETE_TITLE, Messages::CATEGORIES_DELETE_MESSAGE);
        } else {
            $objReturn->setResult(false, Errors::CATEGORIES_EDIT_01_TITLE, Errors::CATEGORIES_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
