<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            border: 1px solid #ccc;
            overflow: hidden;
            padding: 0;
            margin: 0;
            background: transparent;
            border: none;
        }

        input {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 16px;

            border: 1px solid #ccc;
            padding: 0;
            padding-left: 5px;
            margin: 0;
            width: 100%;
            height: 31px;

        }

        .level {
            width: 100%;
            padding: 5px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 5px 0;
            color: #fff;
            background-color: #0568a5;
        }

        .adress {
            cursor: pointer;
            width: 100%;
            padding: 5px 15px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 5px 0;

        }

        .adress:hover {
            color: #fff;
            background-color: #0568a5 !important;

        }



        .adress:nth-child(2n) {

            background-color: #fafafa;
        }

        .adress:nth-child:hover(2n) {

            color: #fff;
            background-color: #0568a5;

        }

        .searchresult {
            overflow-y: scroll;
            overflow-x: hidden;
            height: 360px
        }

        img {
            margin-right: 10px;
        }
    </style>
    <script>
        var request = ajaxCreateRequest();
        var prevval = "";
        var prevlevel = 0;
        var watchsearch = false;
        var interval = 0;
        var currentlevel = 0;
        var blockhash = false;

        var root = "http://192.168.0.65/zod/fias_serv/public/"
       //var root="http://fias.ru/public/"



        request.onreadystatechange = function() {
            if (request.readyState == XMLHttpRequest.DONE) {

                buildadresses(request.responseText);

            }
        }


        function buildadresses(data) {
            document.querySelector(".searchresult").innerHTML = "";
            var json = JSON.parse(data);

            for (t = 0; t < json.length; t++) {
                if (json[t].adress) {
                    if (prevlevel != json[t].level) {
                        document.querySelector(".searchresult").innerHTML = document.querySelector(".searchresult")
                            .innerHTML + '<div class="level">' + ["Регион", "Город", "Улица"][json[t].level - 1] + '</div>';
                        prevlevel = json[t].level;
                    }
                    document.querySelector(".searchresult").innerHTML = document.querySelector(".searchresult").innerHTML +
                        '<div class="adress" onclick="setHash(\'' + json[t].level + '\',\'' + json[t].region + '\',\'' +
                        json[t].city + '\',\'' + json[t].street + '\',\'' + json[t].regionid + '\',\'' + json[t].cityid +
                        '\',\'' + json[t].streetid + '\',\'' + json[t].postcode + '\',\'' + json[t].regiondistrict + '\',\'' + json[t].settlement + '\',\'' +(json[t].house?json[t].house.replace("\\", '\\\\'):"")   + '\',\'' + (json[t].building?json[t].building.replace("\\", '\\\\'):"")   + '\',\'' + (json[t].room?json[t].room.replace("\\", '\\\\'):"") + '\',\'' + (json[t].searchtype?json[t].searchtype:0)+ '\',\'' + (json[t].searchtype?(json[t].adress[json[t].adress.length-1]=="\\"?json[t].adress.substr(0,json[t].adress.length-1):json[t].adress).replace("\\", '\\\\'):"") + '\');currentlevel=\'' + json[t].level +
                        '\'"><img height="20px" src="http://192.168.0.65/zod/img/' + ["region.png", "city.png",
                            "street.png"
                        ][json[t].level - 1] + '"/>' + (json[t].adress[json[t].adress.length-1]=="\\"?json[t].adress.substr(0,json[t].adress.length-1):json[t].adress)  + '</div>';

                      //  console.log(json[t].adress,json[t].adress.replace("\\", '\\\\').replace("/\\$/", '-----'),(json[t].adress[json[t].adress.length-1]=="\\"?json[t].adress.substr(0,json[t].adress.length-1):json[t].adress).replace("\\", '\\\\'));
                }

            }


        }

        function setHash(level, region, city, street, regionid, cityid, streetid, postcode,regiondistrict,settlement,house,building,room,searchtype,gadress) {



            var adress = postcode != "" ? postcode : "";
            adress = adress + (region != "" ? (adress != "" ? "," : "") + region : "");
            adress = adress + (city != "" ? (adress != "" ? "," : "") + city : "");
            adress = adress + (street != "" ? (adress != "" ? "," : "") + street : "");
            adress += ","
            document.querySelector("#searchtext").value = gadress==""?adress:gadress;

            clearInterval(interval);
            interval = 0;
            window.location.hash = "search=&level=" + level + "&region=" + region + "&city=" + city + "&street=" + street +
                "&regionid=" + regionid + "&cityid=" + cityid + "&streetid=" + streetid + "&popup=0&regiondistrict=" + regiondistrict+"&settlement=" + settlement+"&house=" + house+"&building=" + building+"&room=" + room+"&searchtype=" + searchtype+"&postcode="+postcode ;

        }


        function ajaxCreateRequest() {
            var request = false;
            if (window.XMLHttpRequest) {
                request = new XMLHttpRequest;
                //  document.querySelector(".searchresult").innerHTML = "ajax 1 OK"
            } else if (window.ActiveXObject) {
                request = new ActiveXObject("Microsoft.XMLHTTP");
                document.querySelector(".searchresult").innerHTML = "ajax 2 OK"
            }

            if (!request)
                //        alert("This Browser doesn't support my page!");
                document.querySelector(".searchresult").innerHTML = "ajax bad"
            return request;
        }

        function sethash() {
            if (document.querySelector("#searchtext").value.length > 5) {
                currentlevel = document.querySelector("#searchtext").value.split(",").length - 1;
            
                if (prevval != document.querySelector("#searchtext").value) {
                    window.location.hash = "search=" + document.querySelector("#searchtext").value + "&popup=1";
                    prevval = document.querySelector("#searchtext").value;
                    var r=document.querySelector("#searchtext").value*1;
                 
                    if ((typeof r=="number") && (document.querySelector(
                                "#searchtext").value.length == 10 || document.querySelector("#searchtext").value
                            .length == 12)) {
                                request.open('GET', root + 'api/inn/' + document.querySelector(
                            "#searchtext").value, true);
                    
                        request.send(null);
                    } else {

                        request.open('GET', root + 'api/search/' + currentlevel + "/" + document.querySelector(
                            "#searchtext").value, true);
                        request.send(null);
                    }
                }

            } else {
                window.location.hash = "popup=0";

                document.querySelector(".searchresult").innerHTML = ""
            }



        }
    </script>
    <title>Проверка загрузки ФИАС</title>
</head>

<body>
    <div class="searchcontainer">

        <div class="search"><input type="text" name="searchtext" id="searchtext"
                value="{{ isset($text) ? $text : '' }}"
                onkeypress="if(interval==0){interval=setInterval('sethash()', 100);}"></div>
        <div class="searchresult"></div>

    </div>

    <div class="adresses"></div>
</body>

</html>
