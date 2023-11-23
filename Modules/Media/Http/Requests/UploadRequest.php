<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:jpg,jpeg,png|max:2048', // Example rules for an image upload
        ];
    }
}
