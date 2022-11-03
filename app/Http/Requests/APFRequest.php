<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APFRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'target_date' => 'required|date|after:today',
            'duration_val' => 'required|numeric',
            'duration_unit' => 'required',
            'venue' => 'required|max:60',
            'event_title' => 'required|max:45',
            'org_id' => 'required',
            'organizer_name' => 'required',
            'act_classification' => 'required|max:2',
            'act_location' => 'required|max:20',
                // 'NewCoorganizers[*].coorganization' => 'required',
                'coorganization.*' => 'required',
                'coorganizer_name.*' => 'required',
                'coorganizer_phone.*' => 'required',
                'coorganizer_email.*' => 'required',
                'service.*' => 'required',
                'logistics_date_needed.*' => 'required',
                'logistics_venue.*' => 'required',
            'description' => 'required',
            'rationale' => 'required',
            'outcome' => 'required',
            'primary_audience' => 'required',
            'num_primary_audience' => 'required',
            'secondary_audience' => 'required',
            'num_secondary_audience' => 'required',
                'activity.*' => 'required',
                'start_date.*' => 'required',
                'end_date.*' => 'required',



            'coorganizers' => 'required',
            'requests' => 'required',
            'programs' => 'required',
        ];
    }
}
