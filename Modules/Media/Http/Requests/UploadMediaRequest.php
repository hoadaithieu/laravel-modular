<?php namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
{
    /*
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
     */

    public function rules()
    {
        return [
            'file' => ['required', 'max_size'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        //$bytes = config('asgard.media.config.max-total-size');
        $bytes = \Config::get('media.max-total-size');
        $size = $this->formatBytes($bytes);

        return [
            'file.max_size' => trans('media::media.validation.max_size', ['size' => $size]),
        ];
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = [
            trans('media::media.file-sizes.B'),
            trans('media::media.file-sizes.KB'),
            trans('media::media.file-sizes.MB'),
            trans('media::media.file-sizes.GB'),
            trans('media::media.file-sizes.TB'),
        ];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

}
