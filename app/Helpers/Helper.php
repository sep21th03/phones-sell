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


if (!function_exists('getPublicPath')) {
    function getPublicPath($path = '') {
        if (file_exists(base_path('public_html'))) {
            return base_path('public_html/' . $path);
        }
        return public_path($path);
    }
}