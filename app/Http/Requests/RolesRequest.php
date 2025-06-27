<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if ($this->getSegmentFromEnd() != "" && $this->getSegmentFromEnd() != null) {
            return [
                'name' => 'required|unique:roles,name,' . $this->getSegmentFromEnd() . ',id',
            ];
        } else {
            return [
                'name' => 'required|unique:roles,name',
            ];
        }
    }

    private function getSegmentFromEnd($position_from_end = 1) {
        $segments = $this->segments();
        return $segments [sizeof($segments) - $position_from_end];
    }

}
