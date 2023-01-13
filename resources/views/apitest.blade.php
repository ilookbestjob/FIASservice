<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/apitest.css') }}
    
    " />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/apitest.js') }}"></script>

    <title>Проверка загрузки ФИАС</title>
</head>

<body>
    <div class="searchcontainer">
        <div class="searchtext">Введите часть адреса</div>
        <div class="search"><input type="text" name="searchtext" id="searchtext" placeholder="Например, 185014"></div>
        <div class="searchbutton">Поиск</div>
    </div>

    <div class="adresses"></div>
</body>

</html>