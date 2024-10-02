<?php


function jsonResponse($status, $message = '', $data = [])
{
    return response()->json(
        [
            'data' => $data,
            'status' => $status,
            'message' => $message
        ],
        200
    );
}
