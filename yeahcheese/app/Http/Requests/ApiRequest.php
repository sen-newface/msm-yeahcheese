<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator){
    
    }
}
