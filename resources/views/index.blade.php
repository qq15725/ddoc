<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('ddoc.title', '') }}</title>
    <style>
        {!! $css !!}
    </style>
    <style>
        th, td {
            white-space: nowrap;
        }
    </style>
    <script>
        {!! $js !!}
    </script>
</head>
<body>
<div id="app"></div>
<script>
  docute.init({
    title: "{{ config('ddoc.title', '') }}",
    tocVisibleDepth: 3,
    announcement: {!! json_encode(config('ddoc.docute.announcement', []), JSON_UNESCAPED_UNICODE) !!},
    nav: {!! json_encode(config('ddoc.docute.nav', []), JSON_UNESCAPED_UNICODE) !!},
    icons: {!! json_encode(config('ddoc.docute.icons', []), JSON_UNESCAPED_UNICODE) !!}
  })
</script>
</body>
</html>
