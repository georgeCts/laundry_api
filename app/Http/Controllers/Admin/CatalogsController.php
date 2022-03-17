<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Exception;
use App\Catalog;
use App\Category;
use App\Library\Errors;
use App\Library\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Returns\ActionReturn;
use Illuminate\Support\Facades\Storage;

class CatalogsController extends Controller
{
    public function index() {
        $lstCatalogs = Catalog::where('deleted', 0)->orderBy('created_at', 'DESC')->get();
        return view('panel.contents.catalogs.Index', ['lstCatalogs' => $lstCatalogs]);
    }

    public function create() {
        $lstCategories = Category::where('deleted', 0)->orderBy('name', 'ASC')->get();
        $lstBrands = Brand::where('deleted', 0)->orderBy('name', 'ASC')->get();
        return view('panel.contents.catalogs.Create', ['lstCategories' => $lstCategories, 'lstBrands' => $lstBrands]);
    }

    public function store(Request $request) {
        $objReturn = new ActionReturn('panel/catalogos/catalogo-crear', 'panel/catalogos');

        if($request->file('image') && $request->file('pdf')) {
                $file       = $request->file('image');
                $extension  = $file->getClientOriginalExtension();
                $fileName   = time() . '_img_catalogo.' . $extension;
                $url        = '/catalogos/' . $fileName;

                $pdf         = $request->file('pdf');
                $fileNamePDF = time() . '_catalogo.' . $pdf->getClientOriginalExtension();
                $urlPDF      = '/catalogos/' . $fileNamePDF;

                try {
                    if($request->image->storeAs('catalogos', $fileName) && $request->pdf->storeAs('catalogos', $fileNamePDF)) {
                        $objCatalog                     = new Catalog();
                        $objCatalog->name               = $request->name;
                        $objCatalog->category_id        = $request->category_id;
                        $objCatalog->brand_id           = $request->brand_id;
                        $objCatalog->file               = $url;
                        $objCatalog->pdf                = $urlPDF;
                        $objCatalog->save();
    
                        $objReturn->setResult(true, Messages::CATALOGS_CREATE_TITLE, Messages::CATALOGS_CREATE_MESSAGE);
                    } else {
                        $objReturn->setResult(false, Errors::CATALOGS_CREATE_02_TITLE, Errors::CATALOGS_CREATE_02_MESSAGE);
                    }
                } catch(Exception $exception) {
                    $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
                }
        } else {
            $objReturn->setResult(false, Errors::CATALOGS_CREATE_01_TITLE, Errors::CATALOGS_CREATE_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function edit($id) {
        $return = redirect('panel/catalogos');
        $objCatalog = Catalog::where('id', $id)->where('deleted', 0)->first();

        if($objCatalog != null) {
            $lstCategories = Category::where('deleted', 0)->orderBy('name', 'ASC')->get();
            $lstBrands = Brand::where('deleted', 0)->orderBy('name', 'ASC')->get();
            $return = view('panel.contents.catalogs.Edit', ['objCatalog' => $objCatalog, 'lstCategories' => $lstCategories, 'lstBrands' => $lstBrands]);
        }

        return $return;
    }

    public function update(Request $request) {
        $objReturn  = new ActionReturn('panel/catalogos/catalogo-editar/'.$request->hddIdCatalog, 'panel/catalogos');
        $objCatalog   = Catalog::where('id', $request->hddIdCatalog)->first();

        if($objCatalog != null) {
            try {
                $objCatalog->name               = $request->name;
                $objCatalog->category_id        = $request->category_id;
                $objCatalog->brand_id           = $request->brand_id;

                if($request->file('image')) {
                    Storage::delete($objCatalog->file);

                    $file       = $request->file('image');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_img_catalogo.' . $extension;
                    $url        = '/catalogos/' . $fileName;

                    $request->image->storeAs('catalogos', $fileName);
                    $objCatalog->file = $url;
                }

                if($request->file('pdf')) {
                    Storage::delete($objCatalog->pdf);

                    $file       = $request->file('pdf');
                    $extension  = $file->getClientOriginalExtension();
                    $fileName   = time() . '_catalogo.' . $extension;
                    $url        = '/catalogos/' . $fileName;

                    $request->pdf->storeAs('catalogos', $fileName);
                    $objCatalog->pdf = $url;
                }

                if($objCatalog->save())
                    $objReturn->setResult(true, Messages::CATALOGS_EDIT_TITLE, Messages::CATALOGS_EDIT_MESSAGE);
                else
                    $objReturn->setResult(false, Errors::CATALOGS_EDIT_02_TITLE, Errors::CATALOGS_EDIT_02_MESSAGE);
            } catch(Exception $exception) {
                $objReturn->setResult(false, Errors::getErrors($exception->getCode())['title'], Errors::getErrors($exception->getCode())['message']);
            }
        } else {
            $objReturn->setResult(false, Errors::CATALOGS_EDIT_01_TITLE, Errors::CATALOGS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }

    public function delete($id) {
        $objReturn  = new ActionReturn('panel/catalogos', 'panel/catalogos');
        $objCatalog = Catalog::where('id', $id)->where('deleted', 0)->first();

        if($objCatalog != null) {
            $objCatalog->deleted = 1;
            $objCatalog->save();

            $objReturn->setResult(true, Messages::CATALOGS_DELETE_TITLE, Messages::CATALOGS_DELETE_MESSAGE);
        } else {
            $objReturn->setResult(false, Errors::CATALOGS_EDIT_01_TITLE, Errors::CATALOGS_EDIT_01_MESSAGE);
        }

        return $objReturn->getRedirectPath();
    }
}
