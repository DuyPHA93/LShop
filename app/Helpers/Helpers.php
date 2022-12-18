<?php

/**
 * Get response json.
 * @param statusCode Status Code
 * @param data Object Data
 * @param message Message Text
 * @param errors Errors Validation (Array)
 * 
 * @return ResponseJSON
 */
if (!function_exists('responseJSON')) {
    function responseJSON($statusCode, $data = null, $message = null, $errors = null) {
        try {
            return \response()->json([
                'statusCode' => $statusCode, 
                'message' => $message,
                'errors' => $errors,
                'data' => $data
            ], $statusCode);
        } catch (\Exception $e) {
            return \response()->json(null, 400);
        }
    }
}

// Format String
// Example: stringFormat("Hello {0}, I am {1}", "World", "Dev)
// Return "Hello World, I am Dev"
if (!function_exists('stringFormat')) {
    function stringFormat($format, ...$str) {
        try {
            $format = preg_replace('/{(\d+)}/i', '%s', $format);
            return sprintf($format,...$str);
        } catch(\Exception $e) {
            return null;
        }
    }
}

/**
 * Convert date string to Date format.
 * @param dateString Date String
 * 
 * @return Date Date format
 */
if (!function_exists('dDate')) {
    function dDate($dateString) {
        try {
            return date_format(date_create($dateString),'Y-m-d');
        } catch(\Exception $e) {
            return date_format(date_create('1970/01/01'),'Y-m-d');
        }
    }
}