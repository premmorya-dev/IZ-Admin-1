```blade
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>

body{
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:20px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:8px;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    border:1px solid #ddd;
    padding:8px;
    vertical-align:top;
}

pre{
    background:#272822;
    color:#f8f8f2;
    padding:15px;
    overflow:auto;
    white-space:pre-wrap;
    word-break:break-word;
}

</style>
</head>
<body>

<div class="card">

<h2>🚨 Production Error</h2>

<table>

<tr>
<td><b>Message</b></td>
<td>{{ data_get($data, 'message', 'N/A') }}</td>
</tr>

<tr>
<td><b>File</b></td>
<td>{{ data_get($data, 'file', 'N/A') }}</td>
</tr>

<tr>
<td><b>Line</b></td>
<td>{{ data_get($data, 'line', 'N/A') }}</td>
</tr>

<tr>
<td><b>URL</b></td>
<td>{{ data_get($data, 'url', 'N/A') }}</td>
</tr>

<tr>
<td><b>Method</b></td>
<td>{{ data_get($data, 'method', 'N/A') }}</td>
</tr>

<tr>
<td><b>IP</b></td>
<td>{{ data_get($data, 'ip', 'N/A') }}</td>
</tr>

<tr>
<td><b>Time</b></td>
<td>{{ data_get($data, 'time', 'N/A') }}</td>
</tr>

<tr>
<td><b>Environment</b></td>
<td>{{ data_get($data, 'environment', 'N/A') }}</td>
</tr>

<tr>
<td><b>Server</b></td>
<td>{{ data_get($data, 'server', 'N/A') }}</td>
</tr>

<tr>
<td><b>Laravel</b></td>
<td>{{ data_get($data, 'laravel', 'N/A') }}</td>
</tr>

<tr>
<td><b>PHP</b></td>
<td>{{ data_get($data, 'php_version', 'N/A') }}</td>
</tr>

<tr>
<td><b>User Agent</b></td>
<td>{{ data_get($data, 'user_agent', 'N/A') }}</td>
</tr>

<tr>
<td><b>Logged User</b></td>
<td>
<pre>{{ print_r(data_get($data, 'user', 'N/A'), true) }}</pre>
</td>
</tr>

<tr>
<td><b>Request Data</b></td>
<td>
<pre>{{ print_r(data_get($data, 'input', 'N/A'), true) }}</pre>
</td>
</tr>

</table>

<h3>Stack Trace</h3>

<pre>{{ data_get($data, 'trace', 'N/A') }}</pre>

</div>

</body>
</html>
```
