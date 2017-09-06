<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>My Awesome Doc</title>
    <!-- the docute client styles -->
    <link rel="stylesheet" href="https://unpkg.com/docute/dist/docute.css">
</head>
<body>
<div id="app"></div>
<!-- load the docute client library -->
<script src="https://unpkg.com/docute/dist/docute.js"></script>
<!-- bootstrap your docute app! -->
<script>

    var readme_md = function () {/*
<h1 align="center">readme.md</h1>

<a href="https://github.com/dingo/api/wiki/API-Blueprint-Documentation">
    API Blueprint Documentation
</a> for <a href="https://github.com/dingo/api">dingo/api</a>

    */}

    var database_md = function() {/*

## {{ config('app.name', '') }} 数据字典

@foreach($tables as $key => $table)

## {{ $table->Comment }} {{ $table->Name }}

字段 | 类型 | 为空 | 键 | 默认值 | 特性 | 备注
 --- | --- | --- | -- | ----- | --- | ---
@foreach($table->columns as $column)
{{ $column->Field }} | {{ $column->Type }} | {{ $column->Null }} | {{ $column->Key }} | {{ $column->Default }} | {{ $column->Extra }} | {{ $column->Comment }}
@endforeach

@endforeach

        */}

    function toStr (str) {
        var lines = str.toString();
        lines = lines.substring(lines.indexOf("/*") + 2, lines.lastIndexOf("*/"));
        lines = lines.replace(/\\n/g, "\n");
        lines = lines.replace(/\\r/g, "\r");
        return lines.replace(/\\t/g, "\t");
    };

    docute.init({
        nav: [
            {
                title: 'readme',
                path: '/',
                markdown: toStr(readme_md)
            },
            {
                title: '接口文档',
                path: '/api',
                source: '/api.md'
            },
            {
                title: '数据库字典',
                path: '/database',
                markdown: toStr(database_md)
            }
        ]
    })
</script>
</body>
</html>