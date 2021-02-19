<?php

namespace Fennecio\SearchInModel\Requests;

use App\Exceptions\Search\SearchException;
use App\Traits\collection\CollectionHelpers;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    use CollectionHelpers;

    protected const INDEXES = [
        'result_type' => 'is_string',
        'q' => 'is_array',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $inputs = $this->input();

        $check = $this->checkArrayAttributes($inputs,self::INDEXES);

        // foreach ($inputs as $key => $value) {

        //     if (!(array_key_exists($key, self::INDEXES) && call_user_func(self::INDEXES[$key], $value))) {
        //         $check = false;
        //         return;
        //     }
        // }


        if (!$check) throw new SearchException();


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
            //
        ];
    }
}
