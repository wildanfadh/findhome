<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait AjaxResponserTrait
{
    /**
     * Core of response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     * @param   boolean         $isSuccess
     */
    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true): JsonResponse
    {
        // Check the params
        if (!$message) return response()->json(['message' => 'Message is required'], Response::HTTP_INTERNAL_SERVER_ERROR);

        // Send the response
        if ($isSuccess) {
            return response()->json([
                'success' => true,
                'message' => $message,
                // 'code' => $statusCode,
                'results' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'success' => false,
                'message' => $message,
                // 'code' => $statusCode,
            ], $statusCode);
        }
    }

    /**
     * Send any success response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     */
    public function success($message, $data, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->coreResponse($message, $data, $statusCode);
    }

    /**
     * Send any error response
     *
     * @param   string          $message
     * @param   integer         $statusCode
     */
    public function error($message, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }

    /**
     * Send conditional response base on success (true, false) status
     *
     * @param object $data
     * @return JsonResponse
     */
    public function conditionalResponse(object $data): JsonResponse
    {
        if ($data->success) return $this->success($data->message, $data->data, $data->code ?? Response::HTTP_OK);

        return $this->error($data->message, $data->code ?? Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
