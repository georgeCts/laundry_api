<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationUpdateRequest extends FormRequest
{
    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->route('panel.configuraciones.editar', $this->id);
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
            'id' => 'required|integer|exists:configurations,id|exclude',
            'key' => 'required|string|max:255|exclude',
            'description' => 'required|string|max:255|exclude',
            'value'   => 'required|numeric|min:0.01',
        ];
    }

    public function attributes() {
        return [
            'value' => 'Valor',
        ];
    }
}
