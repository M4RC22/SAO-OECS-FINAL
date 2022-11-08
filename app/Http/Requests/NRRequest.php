<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NRRequest extends FormRequest
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
     * @return<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id' =>'required', 
            'venue' => 'required', 
            'narration' => 'required', 

                'activity.*' =>  'required', 
                'start_date.*' => 'required', 
                'end_date.*' => 'required', 

                // 'first_name.*' => 'required', 
                // 'last_name.*' => 'required', 
                // 'section.*' =>'required', 
                // 'participated_date.*' =>'required', 

            //     'comments.*' =>'required', 
            //     'suggestions.*' =>'required', 

            //     'event_images' => 'required',
            //     'event_images.*' => 'image|mimes:png,jpg,jpeg',
            //     'poster.*' => 'image|mimes:png,jpg,jpeg',


            //     'poster' => 'required',
                
            // 'ratings' => 'required', 


            'programs' => 'required',
            'participants' => 'required',
            'comments' => 'required',
            'suggestions' => 'required',
        ];
    }
}
