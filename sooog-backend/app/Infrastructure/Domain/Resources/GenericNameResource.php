<?php

namespace App\Infrastructure\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenericNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id'     => $this->id,
            'name'   => $this->name
        ];

        if ($this->key)
            $response['key'] = $this->key;

        if ($this->type)
            $response['type'] = $this->type;

        if ($this->code)
            $response['code'] = $this->code;

        if (isset($this->is_active))
            $response['is_active'] = $this->is_active;

        if ($this->value)
            $response['value'] = $this->value;

        return $response;
    }
}
