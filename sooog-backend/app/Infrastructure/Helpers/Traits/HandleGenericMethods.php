<?php

namespace App\Infrastructure\Helpers\Traits;

use App\Exceptions\NotAllowedException;
use App\Exceptions\NotFoundException;
use App\Exceptions\PasswordNotMatchException;
use App\Exceptions\UserNotFoundException;
use App\Models\Status;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HandleGenericMethods
{

    public function getBulkStatus($keys)
    {
        $status = Status::whereIn('key', $keys)->get();

        return $status;
    }

    public function getSingleStatus($key)
    {
        try {

            return Status::where('key', $key)->firstOrFail();

        } catch(ModelNotFoundException $e) {

            throw new NotFoundException();
        }
    }

    public function handleApiExceptionType($handlerCode)
    {
        try {

            return $handlerCode;

        } catch (NotFoundException $e) {

            throw new NotFoundException();

        } catch (UserNotFoundException $e) {

            throw new UserNotFoundException();

        } catch (NotAllowedException $e) {

            throw new NotAllowedException();

        } catch (PasswordNotMatchException $e) {

            throw new PasswordNotMatchException();

        } catch (Exception $e) {

            return $this->sendJson($e->getMessage(), 401);
        }
    }

    // public function handleWebExceptionType($handlerCode)
    // {
    //     try {

    //         return $handlerCode;

    //     } catch (NotFoundException $e) {

    //         throw new HandleRedirectException(trans('trans-api.item_not_found'));

    //     } catch (UserNotFoundException $e) {

    //         throw new HandleRedirectException(trans('trans-api.user_not_found'));

    //     } catch (NotAllowedException $e) {

    //         throw new HandleRedirectException(trans('trans-api.not_allowed_exception'));

    //     } catch (PasswordNotMatchException $e) {

    //         throw new HandleRedirectException(trans('trans-api.password_not_match'));

    //     } catch (Exception $e) {

    //         throw new HandleRedirectException(trans('trans-website.failed'));
    //     }
    // }

}
