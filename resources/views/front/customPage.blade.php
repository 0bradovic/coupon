<html>
<head>
    <title>{{$customPage->name}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('public/front/style.css') }}" />
</head>
<body>
<div class="container">{!! html_entity_decode($customPage->text) !!}</div>
</body>
</html>