<?php

/**
* Success response method
*
* @param $result
* @param $message
* @return \Illuminate\Http\JsonResponse
*/
function sendResponse($result, $message = null)
{
    $response = [
        'success' => true,
        'data'    => $result,
    ];

    if(!is_null($message)) $response["message"] = $message;

    return response()->json($response, 200);
}

/**
* Success response method
*
* @param $result
* @param $message
* @return \Illuminate\Http\JsonResponse
*/
function sendSuccess($message)
{
    $response = [
        'success' => true,
        'message' => $message,
    ];

    return response()->json($response, 200);
}

/**
* Return error response
*
* @param       $error
* @param array $errorMessages
* @param int   $code
* @return \Illuminate\Http\JsonResponse
*/
function sendError($error, $code = 404)
{
    $response = [
        'success' => false,
        'message' => $error,
    ];

    return response()->json($response, $code);
}
