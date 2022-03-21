<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCatalogUpdateRequest extends FormRequest
{
    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->route('panel.servicios-catalogo.editar', $this->id);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:services_catalog,id|exclude',
            'name_es' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'basic_price'   => 'required|numeric|min:0.01',
            'express_price' => 'required|numeric|min:0.01',
            'unit_type_id'  => 'required|exists:unit_types,id'
        ];
    }

    public function attributes() {
        return [
            'name_es'       => 'Nombre (ES)',
            'name_en'       => 'Nombre (EN)',
            'basic_price'   => 'Precio básico',
            'express_price' => 'Precio express',
            'unit_type'     => 'Tipo de unidad'
        ];
    }
}
