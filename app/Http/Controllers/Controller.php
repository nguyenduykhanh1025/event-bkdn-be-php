<?php

namespace App\Http\Controllers;

use App\DTOs\Response\ResponseDTO;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseError($message, $httpStatus)
    {
        return response()->json((new ResponseDTO())->setMessage($message)->getResponse(), $httpStatus);
    }

    protected function responseSuccess($data, $httpStatus = Response::HTTP_OK)
    {
        return response()->json((new ResponseDTO())->setData($data)->setMessage('oke')->getResponse(), $httpStatus);
    }
}
