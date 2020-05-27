<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'release_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:release_date'],
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'イベントタイトルは必須項目です',
            'title.max' => 'イベントタイトルは255文字まで設定できます',

            'release_date.required' => 'イベント公開開始日は必須項目です',
            'release_date.date' => 'イベント公開開始日は日付形式で入力してください',
            'release_date.after_or_equal' => 'イベント公開開始日は本日以降の日付である必要があります',

            'end_date.required' => 'イベント公開終了日は必須項目です',
            'end_date.date' => 'イベント公開終了日は日付形式で入力してください',
            'end_date.after' => 'イベント公開終了日はイベント公開開始日より後の日付である必要があります',
        ];
    }
}
