<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>

body{
    font-family:Arial;
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
}

</style>
</head>
<body>

<div class="card">

<h2>🚨 Production Error</h2>

<table>

<tr>
<td><b>Message</b></td>
<td>{{ $data['message'] }}</td>
</tr>

<tr>
<td><b>File</b></td>
<td>{{ $data['file'] }}</td>
</tr>

<tr>
<td><b>Line</b></td>
<td>{{ $data['line'] }}</td>
</tr>

<tr>
<td><b>URL</b></td>
<td>{{ $data['url'] }}</td>
</tr>

<tr>
<td><b>Method</b></td>
<td>{{ $data['method'] }}</td>
</tr>

<tr>
<td><b>IP</b></td>
<td>{{ $data['ip'] }}</td>
</tr>

<tr>
<td><b>Time</b></td>
<td>{{ $data['time'] }}</td>
</tr>

<tr>
<td><b>Environment</b></td>
<td>{{ $data['environment'] }}</td>
</tr>

<tr>
<td><b>Server</b></td>
<td>{{ $data['server'] }}</td>
</tr>

<tr>
<td><b>Laravel</b></td>
<td>{{ $data['laravel'] }}</td>
</tr>

<tr>
<td><b>PHP</b></td>
<td>{{ $data['php_version'] }}</td>
</tr>

<tr>
<td><b>User Agent</b></td>
<td>{{ $data['user_agent'] }}</td>
</tr>

<tr>
<td><b>Logged User</b></td>
<td>
<pre>{{ print_r($data['user'], true) }}</pre>
</td>
</tr>

<tr>
<td><b>Request Data</b></td>
<td>
<pre>{{ print_r($data['input'], true) }}</pre>
</td>
</tr>

</table>

<h3>Stack Trace</h3>

<pre>{{ $data['trace'] }}</pre>

</div>

</body>
</html>