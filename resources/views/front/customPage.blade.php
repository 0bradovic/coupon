<html>
<header>
    <title>{{$customPage->name}}</title>
</header>
<body>
<div>{!! html_entity_decode($customPage->text) !!}</div>
</body>
</html>