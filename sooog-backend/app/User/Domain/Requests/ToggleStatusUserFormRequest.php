<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use App\User\Domain\Models\User;
class ToggleStatusUserFormRequest extends CustomApiRequest
{
    public function rules()
    {
        $user = User::find($this->id);
        if($user && $user->is_active == 1)
        	return [
	            'reason' => ['required', 'string', 'min:2', 'max:1000'],
	        ];
	    return [];    
    }
}
