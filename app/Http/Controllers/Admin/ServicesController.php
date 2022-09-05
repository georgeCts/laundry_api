<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ServiceDetail;
use App\Models\ServiceCatalog;
use App\Services\ExpoNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\StatusUpdateNotification;

class ServicesController extends Controller
{
    public function pendingList()
    {
        $lstServices = Service::where('status', 'PENDING')->orderBy('created_at', 'DESC')->get();
        return view('contents.services.Pending', ['lstServices' => $lstServices]);
    }

    public function acceptedList()
    {
        $lstServices = Service::where('status', 'ACCEPTED')->orWhere('status', 'ON PROGRESS')->orderBy('created_at', 'ASC')->get();
        return view('contents.services.Accepted', ['lstServices' => $lstServices]);
    }

    public function finishedList()
    {
        $lstServices = Service::where('status', 'FINISHED')->orWhere('status', 'CANCELLED')->orderBy('created_at', 'ASC')->get();
        return view('contents.services.Finalized', ['lstServices' => $lstServices]);
    }

    public function processService($serviceId, $serviceStatus)
    {
        try {
            $objService = Service::find($serviceId);

            if (!is_null($objService)) {
                if ($serviceStatus == 'ACCEPTED' && $objService->status == 'PENDING') {
                    $objService->status = 'ACCEPTED';
                    $objService->save();

                    // Notificacion al usuario APP
                    $message = trans('messages.notification_service_accepted', [], $objService->user->locale);
                    (new ExpoNotification($objService->user->device_id, $message))->send();

                    Session::flash('success_message', trans('messages.service_accepted'));
                    return redirect('panel/servicios/aceptados');
                }

                if ($serviceStatus == 'FINISHED' && $objService->status == 'ON PROGRESS') {
                    $objService->status = 'FINISHED';
                    $objService->dt_end = now();
                    $objService->save();

                    // Notificacion al usuario APP
                    $message = trans('messages.notification_service_finalized', [], $objService->user->locale);
                    (new ExpoNotification($objService->user->device_id, $message))->send();

                    Session::flash('success_message', trans('messages.service_pending_delivery'));
                    return redirect('panel/servicios/finalizados');
                }

                if ($serviceStatus == 'FINISHED' && $objService->status == 'FINISHED') {
                    $objService->dt_finalized = now();
                    $objService->delivered = true;
                    $objService->save();

                    // Notificacion al usuario APP
                    $message = trans('messages.notification_service_delivered', [], $objService->user->locale);
                    (new ExpoNotification($objService->user->device_id, $message))->send();

                    Session::flash('success_message', trans('messages.service_completed'));
                    return Redirect::back();
                }

                if ($serviceStatus == 'CANCELLED' && !$objService->cancelled) {
                    $objService->status = 'CANCELLED';
                    $objService->cancelled = true;
                    $objService->dt_cancelled = now();
                    $objService->save();

                    // Notificacion al usuario APP
                    $message = trans('messages.notification_service_cancelled', [], $objService->user->locale);
                    (new ExpoNotification($objService->user->device_id, $message))->send();

                    Session::flash('success_message', trans('messages.service_cancelled'));
                    return redirect('panel/servicios/finalizados');
                }
            }

            return Redirect::back()->withErrors(['error_message' => trans('errors.service_process')]);
        } catch (Exception $ex) {
            return Redirect::back()->withErrors(['error_message' => trans('errors.service_process')]);
        }
    }

    public function configureService($serviceId)
    {
        $objService = Service::find($serviceId);

        if (!is_null($objService)) {
            if ($objService->status == "ACCEPTED") {
                $lstServices = ServiceCatalog::with('unitType:id,name')->where('active', true)->orderBy('name_es', 'ASC')->get();

                return view('contents.services.Start', ['lstServices' => $lstServices, 'objService' => $objService]);
            }
        }

        return Redirect::back()->withErrors(['error_message' => trans('errors.service_process')]);
    }

    public function startService(Request $request)
    {

        try {
            DB::beginTransaction();
            $objService = Service::find($request->serviceId);
            $subtotal = 0;
            $tax = 0;
            $total = 0;

            if ($objService->status == 'ACCEPTED') {
                if (sizeof($request->catalog) > 0 && sizeof($request->quantity) > 0) {
                    $dateHour = explode(",", $request->dateHourFinalized);
                    $dateFinalized = explode("/", $dateHour[0]);
                    $hourFinalized = trim($dateHour[1]) . ":00";

                    $objService->status = 'ON PROGRESS';
                    $objService->dt_start = now();
                    $objService->dt_end = "{$dateFinalized[2]}-{$dateFinalized[1]}-{$dateFinalized[0]} {$hourFinalized}";
                    $objService->save();

                    foreach ($request->catalog as $key => $value) {
                        $objServiceCatalog = ServiceCatalog::find($value);
                        $catalogValue = $objService->express ? $objServiceCatalog->express_price : $objServiceCatalog->basic_price;
                        $total = $catalogValue * (float)$request->quantity[$key];

                        $detail = new ServiceDetail();
                        $detail->service_id = $request->serviceId;
                        $detail->service_catalog_id = $value;
                        $detail->quantity = $request->quantity[$key];
                        $detail->total = $total;
                        $detail->save();

                        $subtotal = $subtotal + $total;
                    }

                    $objConfigTax = Configuration::where('key', 'IVA')->first();
                    $objConfigService = Configuration::where('key', 'SERVICIO_DOMICILIO')->first();
                    $taxPercentage = (float)$objConfigTax->value / 100;
                    $subtotal = $subtotal + (float)$objConfigService->value;
                    $tax = $subtotal * $taxPercentage;
                    $total = $subtotal + $tax;

                    $objService->subtotal = $subtotal;
                    $objService->tax = $tax;
                    $objService->total = $total;
                    $objService->save();

                    // Notificacion al usuario APP
                    $message = trans('messages.notification_service_on_progress', [], $objService->user->locale);
                    (new ExpoNotification($objService->user->device_id, $message))->send();

                    DB::commit();
                    Session::flash('success_message', trans('messages.service_on_progress'));
                    return redirect('panel/servicios/aceptados');
                } else {
                    DB::rollBack();
                    return Redirect::back()->withErrors(['error_message' => trans('errors.service_catalog_length')]);
                }
            }

            DB::rollBack();
            return Redirect::back()->withErrors(['error_message' => trans('errors.service_process')]);
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return Redirect::back()->withErrors(['error_message' => trans('errors.service_process')]);
        }
    }
}
