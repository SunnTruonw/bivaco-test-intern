<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'keyword' => 'required',
            'title_seo' => 'required',
            'description_seo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'vui lòng điền tên danh mục',
            'description.required' => 'vui lòng điền mô tả danh mục',
            'content.required' => 'vui lòng điền nội dung danh mục',
            'keyword.required' => 'vui lòng điền từ khóa danh mục',
            'title_seo.required' => 'vui lòng điền tiêu đề seo danh mục',
            'description_seo.required' => 'vui lòng điền mô tả seo danh mục',
        ];
    }
}
