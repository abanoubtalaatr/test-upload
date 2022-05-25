<?php

namespace App\AppContent\Domain\Services\API;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\AppContent\Domain\Models\Faq;
use App\AppContent\Domain\Resources\FaqResource;
use App\Infrastructure\Exceptions\ModelNotFoundException;

class UpdateFaqService extends Service
{
    public function handle($data = []) 
    {
        try {
            $faq = Faq::findOrFail($data['faq_id']);
            $faq->update($data);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        return new GenericPayload($faq);

    }
}