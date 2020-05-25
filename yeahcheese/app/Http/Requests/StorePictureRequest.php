<?php

namespace App\Http\Requests;

class StorePictureRequest extends ApiRequest
{
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
            'file' => ['file', 'mimes:jpeg,jpg', 'between:100,1024'],
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'jpgまたはjpeg形式にしてください',
            'file.between' => '100KB以上、1MB以下の画像にしてください',
        ];
    }

}
