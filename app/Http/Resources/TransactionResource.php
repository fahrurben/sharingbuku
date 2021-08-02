<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'requestor' => new UserResource($this->requestor),
            'listing' => new ListingResource($this->listing),
            'status' => $this->status,
            'resolution' => $this->resolution,
            'send_receipt' => $this->send_receipt,
            'send_back_receipt' => $this->send_back_receipt,
            'requested_at' => $this->requested_at,
            'approved_at' => $this->approved_at,
            'sent_at' => $this->sent_at,
            'received_at' => $this->received_at,
            'sent_back_at' => $this->sent_back_at,
            'received_back_at' => $this->received_back_at,
        ];
    }
}
