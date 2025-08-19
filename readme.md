# HTTP Status Serverless

A simple serverless function that returns HTTP responses with specified status codes. This utility is perfect for testing how your applications handle different HTTP status codes in a serverless environment.

## Features

- Returns any valid HTTP status code (100-599)
- Configurable response delay for timeout testing
- Proper handling of special status codes (1xx, 204, 304) that shouldn't have a body
- JSON response body with status information for standard responses

## Installation

### Prerequisites

- PHP 8.0 or higher
- PHP ext-ctype extension

### Setup

1. Clone this repository:
   ```
   git clone https://github.com/yourusername/http-status-serverless.git
   cd http-status-serverless
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Deploy to your serverless platform of choice (AWS Lambda, Azure Functions, etc.)

## Usage

### Basic Usage

To get a response with a specific HTTP status code, make a request to the endpoint with the status code as the path:

```
GET https://your-serverless-endpoint.com/404
```

This will return a 404 status code with a JSON body:

```json
{
  "status": 404
}
```

### Special Status Codes

Status codes that shouldn't have a body (1xx, 204, 304) will return an empty response body:

```
GET https://your-serverless-endpoint.com/204
```

This will return a 204 status code with no body.

### Delayed Responses

You can test timeout handling by adding a `sleep` query parameter (in milliseconds):

```
GET https://your-serverless-endpoint.com/200?sleep=2000
```

This will wait 2 seconds before returning a 200 status code.

### Error Handling

If you provide an invalid status code, you'll get a 400 Bad Request response:

```
GET https://your-serverless-endpoint.com/999
```

Response:
```json
{
  "error": "Path moet een geldige HTTP-statuscode (100-599) zijn.",
  "path": "999"
}
```

## Examples

### Testing a successful response
```
GET https://your-serverless-endpoint.com/200
```

### Testing a client error
```
GET https://your-serverless-endpoint.com/403
```

### Testing a server error
```
GET https://your-serverless-endpoint.com/500
```

### Testing a redirect
```
GET https://your-serverless-endpoint.com/301
```

### Testing a timeout (3 second delay)
```
GET https://your-serverless-endpoint.com/200?sleep=3000
```

## License

This project is licensed under the MIT License - see below for details:

```
MIT License

Copyright (c) 2025 Just ICT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```