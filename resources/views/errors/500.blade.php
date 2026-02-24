<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error</title>
    <style>
        body { font-family: sans-serif; padding: 50px; text-align: center; background: #f8fafc; color: #1e293b; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        h1 { color: #e11d48; margin-bottom: 20px; }
        pre { background: #fee2e2; padding: 20px; text-align: left; border-radius: 8px; overflow-x: auto; font-size: 14px; border: 1px solid #fecaca; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>500 Internal Server Error</h1>
        <p>Something went wrong on our end. We've been notified and are looking into it.</p>
        
        @if(isset($exception))
            <pre>{{ $exception->getMessage() }}
            
Stack Trace:
{{ $exception->getTraceAsString() }}</pre>
        @endif
        
        <a href="/" class="btn">Go Back Home</a>
    </div>
</body>
</html>
