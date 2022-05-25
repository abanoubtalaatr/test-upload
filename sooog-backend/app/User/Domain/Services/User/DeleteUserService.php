<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\QueryException;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserService extends Service
{
    public function handle($data = []) 
    {
        try {
            $user = User::findOrFail($data['user_id']);
            if(count($user->orders()->get()) > 0)
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            $user->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (\Exception $ex) {
            throw new QueryException;
        }
        return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);

    }
}