<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}" />


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ asset('/js/main.js') }}"></script>
</head>

<body>

    <div class="uploadsetup">
        <div class="header">Настройка загрузки</div>
        <div class="content">

            <!--
            <form id="fileform" style="display:none" method="post" action="http://fias.ru/public/upload/file" enctype="multipart/form-data">
                <input type="file" name="image">
                @csrf
                <button type="submit">Отп</button>
            </form>
            <div style="display:none;">

                <input type="file" id="file" class="file" name="file" />
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            </div>
            -->
            <div class="types">
                <div class="header"><strong>Тип загрузки</strong></div>
                <div class="tcontentcontainer ">
                    <div class="tcontent"><input type="checkbox" name="" id="1" checked>Индексы и номера домов
                    </div>
                    <div class="tcontent"><input type="checkbox" name="" id="2" checked>Районы</div>
                    <div class="tcontent"><input type="checkbox" name="" id="3" checked>Привязать районы к городам</div>
                </div>
            </div>

            <div class="regionscontainer">
                <div class="regions"> </div>
                <div class="footer">
                    <div class="button" id="region">Выбрать</div>
                </div>

            </div>

        </div>
        <div class="footer">

            <div class="button" id="fromuploaded">Из загруженного</div>
            <div class="button" id="fromuploaded">Online</div>
            <div class="button" id="upload">Загрузить файл</div>
        </div>
    </div>
    <!---------->

    <div class="progressinfo" style="display:none;">
        <div class="header">Прогресс загрузки...</div>
        <div class="content">
            <div class="progress" id="regionsprogressinfo">
                <div class="info"></div>
                <div class="progressbarcontainer">
                    <div class="progressbar"></div>
                </div>
            </div>

            <div class="progress" id="baseprogressinfo">
                <div class="info"></div>
                <div class="progressbarcontainer">
                    <div class="progressbar"></div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="button" id="stop">Отменить</div>
        </div>
    </div>
    <div class="text" id="uploadtext">Выберите способ получения ФИАС. Дождитесь загрузки.</div>

    <div class="popup">
        <div class="popupdata"></div>
        <div class="footer">
            <div class="button" id="closepopup">Закрыть</div>
        </div>
    </div>
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
</body>

</html>
