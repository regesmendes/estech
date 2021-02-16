<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        try {
            return $this->{$method}(...array_values($parameters));
        } catch (Throwable $e) {
            // log the error accordingly for further investigation
            $errorCode = $e->getCode();
            $message = config("constants.errors.$errorCode", config("constants.errors.defaultMessage"));

            return response()->json([
                'status' => 'error',
                'message' => $message,
                'or_error' => $e->__toString(),
                'trace' => $e->getTrace()
            ]);
        }
    }
}
