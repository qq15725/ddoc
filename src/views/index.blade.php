<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>{{ config('app.name', '') }} Doc</title>
    <link rel="stylesheet" href="{{ asset('vendor/ddoc/css/docute.css') }}">
</head>
<body>
<div id="app"></div>
<script src="{{ asset('vendor/ddoc/js/docute.js') }}"></script>
<script>
    docute.init({
        @if(config('ddoc.auth.enable', true))
            @if(session()->get('ddoc_password') != config('ddoc.auth.password', 'root'))
            landing: {
                source: "/ddoc/login.html"
            },
            @endif
        @endif
        announcement: {
            type: 'success',
            html: 'Welcome to the documentation'
        },
        nav: [
            {
                title: 'readme',
                path: '/',
                source: '/ddoc/readme'
            },
            {
                title: '接口文档',
                path: '/api',
                source: '/ddoc/api'
            },
            {
                title: '数据库字典',
                path: '/database',
                source: '/ddoc/database'
            }
        ],
        icons: [{
            icon: 'github',
            label: '给项目来个 Star 吧 !',
            link: 'https://github.com/qq15725/ddoc'
        }]
    })
</script>
</body>
</html>