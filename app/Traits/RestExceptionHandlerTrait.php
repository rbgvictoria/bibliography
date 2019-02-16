<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
USE Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @OA\Schema(
     *   schema="Exception",
     *   type="object",
     *   required={"status", "code"},
     *     @OA\Property(
     *       property="status",
     *       type="integer"
     *     ),
     *     @OA\Property(
     *       property="code",
     *       type="string"
     *     ),
     *     @OA\Property(
     *       property="title",
     *       type="string"
     *     ),
     *     @OA\Property(
     *       property="detail",
     *       type="string"
     *     )
     * )
     * 
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch(true) {
            case $this->isNotFoundHttpException($e):
                $retval = $this->notFoundHttpException();
                break;
            default:
                $retval = $this->badRequest($e);
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest(Exception $exception, $message='Bad request', $statusCode=400)
    {
      $message = [
        'errors' => [[
            'status' => $statusCode,
            'code' => '11000',
            'title' => 'Bad request',
            'detail' => $exception->getTrace()
        ]]
    ];
    return $this->jsonResponse($message, 400);
}

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload=null, $statusCode=404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the exception is a TaxonHasSynonymsException
     *
     * @param Exception $e
     * @return bool
     */
    protected function isNotFoundHttpException(Exception $e)
    {
        return $e instanceof NotFoundHttpException;
    }

    /**
     * Returns JSON response for TaxonHasSynonymsException exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundHttpException()
    {
        $message = [
            'errors' => [[
                'status' => "404",
                'code' => '11001',
                'title' => 'Not Found HTTP Exception',
                'detail' => 'The requested resource could not be found'
            ]]
        ];
        return $this->jsonResponse($message, 404);
    }

}