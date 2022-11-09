<?php

namespace App\Utilities;

use App\Exceptions\BadRequestException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnknownException;
use Exception;
use Illuminate\Http\Response;

class HttpHelpers
{

    /**
     *
     * Retrieve the http message and status code for a given exception
     *
     * @return array
     */


    function getHttpMessageAndStatusCodeFromException(Exception $exception)
    {
        return [
            $exception->getMessage(),
            match (get_class($exception)) {
                BadRequestException::class => Response::HTTP_BAD_REQUEST,
                NotFoundException::class => Response::HTTP_NOT_FOUND,
                ForbiddenException::class => Response::HTTP_FORBIDDEN,
                UnknownException::class => Response::HTTP_INTERNAL_SERVER_ERROR,
                default => Response::HTTP_INTERNAL_SERVER_ERROR
            },
            $exception->getCode(),
        ];
    }
}
