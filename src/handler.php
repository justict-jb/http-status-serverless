<?php

/**
 * @author Just ICT
 * @version 1.0.0
 *
 * $event contains some data from the request in an array
 * ['path'] is the path starting with a slash (/)
 * ['queryStringParameters'] is the query string. e.g. ?id=1 will return
 * {
 *   id: "1"
 * }
 * ['body'] contains the text body with needs to be parsed before
 * ['headers'] contains as string map with headers
 * ['method'] string containing the HTTP method
 * ['isBase64Encoded'] boolean if the body is encoded base64.
 */

function handler($event, $context)
{
    ///
    /// Set the default timezone
    ///
    date_default_timezone_set('Europe/Amsterdam');
    ///
    /// Set some parameters from the event
    ///
    $path = $event['path'];
    $method = strtoupper($event['httpMethod']);
    $queryStringParameters = $event['queryStringParameters'];
    $headers = (array)$event['headers'];
    $isBase64Encoded = $event['isBase64Encoded'];
    $body = $event['body'];

    ///
    /// Remove trailing slash from the path
    ///
    if (str_ends_with($path, '/')) $path = substr($path, 0, -1);
    if (str_starts_with($path, '/')) $path = substr($path, 1);


    // Controleer of path een geldige HTTP-statuscode is (100–599)
    if ($path === '' || !ctype_digit($path)) {
        return [
            'statusCode' => 400,
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'error' => 'Path moet een geldige HTTP-statuscode (100-599) zijn.',
                'path'  => $path,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'isBase64Encoded' => false,
        ];
    }

    $statusCode = (int)$path;

    if ($statusCode < 100 || $statusCode > 599) {
        return [
            'statusCode' => 400,
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'error' => 'Path moet een geldige HTTP-statuscode (100-599) zijn.',
                'path'  => $path,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'isBase64Encoded' => false,
        ];
    }
    /// Sleep functie laat de code X milliseconde slapen.
    if(isset($queryStringParameters['sleep'])) {
        $sleep = (int)$queryStringParameters['sleep'];
        if($sleep > 0 && $sleep < 100000) {
            ///Sleep X milliseconds
            usleep($sleep * 1000);
        }
    }

    // Codes zonder body: 1xx, 204, 304
    $noBody = ($statusCode >= 100 && $statusCode < 200) || $statusCode === 204 || $statusCode === 304;

    if ($noBody) {
        return [
            'statusCode' => $statusCode,
            'headers' => $headers,
            'body' => '',
            'isBase64Encoded' => false,
        ];
    }

    // Standaard: JSON body met bevestiging
    return [
        'statusCode' => $statusCode,
        'headers' => ['Content-Type' => 'application/json'] + $headers,
        'body' => json_encode([
            'status' => $statusCode,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        'isBase64Encoded' => false,
    ];

}