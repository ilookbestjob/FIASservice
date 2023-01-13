<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class apiController extends Controller
{

    public $FirstLevelStreetCities = [112];
    public $regions = [
        1 => "Республика Адыгея",
        4 => "Республика Алтай",
        2 => "Республика Башкортостан",
        3 => "Республика Бурятия",
        5 => "Республика Дагестан",
        6 => "Республика Ингушетия",
        7 => "Кабардино-Балкарская республика",
        8 => "Республика Калмыкия",
        9 => "Карачаево-Черкесская республика",
        10 => "Республика Карелия",
        11 => "Республика Коми",
        91 => "Республика Крым",
        12 => "Республика Марий Эл",
        13 => "Республика Мордовия",
        14 => "Республика Саха (Якутия)",
        15 => "Республика Северная Осетия — Алания",
        16 => "Республика Татарстан",
        17 => "Республика Тыва",
        18 => "Удмуртская республика",
        19 => "Республика Хакасия",
        20 => "Чеченская республика",
        21 => "Чувашская республика",
        22 => "Алтайский край",
        75 => "Забайкальский край",
        41 => "Камчатский край",
        23 => "Краснодарский край",
        24 => "Красноярский край",
        59 => "Пермский край",
        25 => "Приморский край",
        26 => "Ставропольский край",
        27 => "Хабаровский край",
        28 => "Амурская область",
        29 => "Архангельская область",
        30 => "Астраханская область",
        31 => "Белгородская область",
        32 => "Брянская область",
        33 => "Владимирская область",
        34 => "Волгоградская область",
        35 => "Вологодская область",
        36 => "Воронежская область",
        37 => "Ивановская область",
        38 => "Иркутская область",
        39 => "Калининградская область",
        40 => "Калужская область",
        42 => "Кемеровская область",
        43 => "Кировская область",
        44 => "Костромская область",
        45 => "Курганская область",
        46 => "Курская область",
        47 => "Ленинградская область",
        48 => "Липецкая область",
        49 => "Магаданская область",
        50 => "Московская область",
        51 => "Мурманская область",
        52 => "Нижегородская область",
        53 => "Новгородская область",
        54 => "Новосибирская область",
        55 => "Омская область",
        56 => "Оренбургская область",
        57 => "Орловская область",
        58 => "Пензенская область",
        60 => "Псковская область",
        61 => "Ростовская область",
        62 => "Рязанская область",
        63 => "Самарская область",
        64 => "Саратовская область",
        65 => "Сахалинская область",
        66 => "Свердловская область",
        67 => "Смоленская область",
        68 => "Тамбовская область",
        69 => "Тверская область",
        70 => "Томская область",
        71 => "Тульская область",
        72 => "Тюменская область",
        73 => "Ульяновская область",
        74 => "Челябинская область",
        76 => "Ярославская область",
        77 => "Москва",
        78 => "Санкт-Петербург",
        92 => "Севастополь",
        79 => "Еврейская автономная область",
        83 => "Ненецкий автономный округ",
        86 => "Ханты-Мансийский автономный округ - Югра",
        87 => "Чукотский автономный округ",
        89 => "Ямало-Ненецкий автономный округ"
    ];



    public function search($level, $search)
    {
        $adress = [];


        //$llevel=count(explode(",",$search));
        //$level=

        header("Access-Control-Allow-Origin:*");

        if ($level == 0) {
            $search = trim($search);

            if (is_numeric($search)) {


                $sql = 'SELECT distinct(zsn.name) street, postalcode as postcode,zc.city city,zr.name region,concat(zh.postalcode,", ",zr.name,", ",  zc.city,", ", zsn.name) as adress, 3 as level,zc.row_id as cityid, zs.row_id as streetid,zr.row_id regionid FROM zod01.zodCityHouse zh , zod01.zodCityStreet zs, zod01.zodCityStreetName zsn, zod01.zodCityStreetType zst, zod01.zodCity zc, zod01.zodCityRegion zr  where zh.streetid=zs.row_id and zs.citystreetname_id=zsn.row_id  and zc.row_id=zs.city_id and zc.cityregion_id=zr.row_id and zh.postalcode=' . $search;

                //echo $sql;
            } else {



                $sql = 'SELECT zr.name adress , zr.name region, "" as city, ""  as street,zr.row_id regionid, "" as cityid, ""  as streetid, "" as postcode, 1 as level FROM zod01.zodCityRegion zr where zr.name like "%' . $search . '%" union SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",zc.city) as adress, (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) region, zc.city as city, ""  as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid,"" as streetid, "" as postcode,2 as level          FROM zod01.zodCity zc where zc.city like "%' . $search . '%" union SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",     zc.city,", ", sn.name) as adress, (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )region, zc.city as city, sn.name  as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid, zs.row_id as streetid, "" as postcode, 3 as level          FROM zod01.zodCityStreet zs,zod01.zodCity zc,        zod01.zodCityStreetName as sn  where sn.row_id=zs.citystreetname_id  and zc.row_id=zs.city_id and zc.row_id in (' . implode(",", $this->FirstLevelStreetCities) . ') and sn.name like "%' . $search . '%" ';


                // echo $sql;
            }


            $adress = DB::select($sql, []);
        } else {

            if ($level == 1) {
                $search = explode(",", $search);

                $sql = 'select * from (SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",zc.city) as adress, (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) region, zc.city as city, ""  as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid,"" as streetid,2 as level          FROM zod01.zodCity zc) sel where sel.region="' . trim($search[0]) . '"  and sel.city like "%' . trim($search[1]) . '%" union select * from (SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",     zc.city,", ", sn.name) as adress, (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )region, zc.city as city, sn.name  as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid, zs.row_id as streetid, 3 as level          FROM zod01.zodCityStreet zs,zod01.zodCity zc,        zod01.zodCityStreetName as sn  where sn.row_id=zs.citystreetname_id  and zc.row_id=zs.city_id and sn.name like "%' . trim($search[1]) . '%") sel where sel.region="' . trim($search[0]) . '"';





                $sql = 'SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",zc.city) as adress, 
               (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )as region, 
               zc.city as city, "" as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, 
               zc.row_id as cityid,"" as streetid, "" as postcode,2 as level FROM zod01.zodCity zc where (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )="' . trim($search[0]) . '" and city like "%' . trim($search[1]) . '%" 
               
               union  
               
                select concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ", zc.city,", ", sn.name) as adress, 
               (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )region, zc.city as city, sn.name as street,
               (SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid, zs.row_id as streetid, "" as postcode, 3 
               as level FROM zod01.zodCityStreet zs,zod01.zodCity zc, zod01.zodCityStreetName as sn 
               where sn.row_id=zs.citystreetname_id and zc.row_id=zs.city_id and sn.name like "%' . trim($search[1]) . '%" and (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )="' . trim($search[0])  . '"';




                $adress = DB::select($sql, []);
            }
            if ($level == 2) {

                $search = explode(",", $search);

                $sql = 'select * from(SELECT concat((SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ),", ",     zc.city,", ", sn.name) as adress, (SELECT name FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 )region, zc.city as city, sn.name  as street,(SELECT row_id FROM zod01.zodCityRegion where zod01.zodCityRegion.namelit=zc.region limit 1 ) regionid, zc.row_id as cityid, zs.row_id as streetid,"" as postcode,3 as level          FROM zod01.zodCityStreet zs,zod01.zodCity zc,        zod01.zodCityStreetName as sn  where sn.row_id=zs.citystreetname_id  and zc.row_id=zs.city_id and sn.name like "%' . trim($search[2]) . '%") sel where sel.region="' . trim($search[0]) . '" and sel.city="' . trim($search[1]) . '" ';
                $adress = DB::select($sql, []);
            }
        }
        echo json_encode($adress);
    }

    function getRegions()
    {

        header("Access-Control-Allow-Origin:*");
        $sql = "SELECT * FROM zod01.zodCityRegion  order by name";

        $regions = DB::select($sql, []);

        echo json_encode($regions);
    }


    function getCities($region)
    {
        //$sql = "SELECT zs.city as name, zs.row_id,ft.name as type FROM zod01.zodCity zs,zod01.zodFiasTypes ft where zs.citytype_id=ft.code and cityregion_id=" . $region." order by name";

        header("Access-Control-Allow-Origin:*");
        $sql = "SELECT trim(zs.city) as name, zs.row_id, (case when (ft.name  is not null) then (case when (locate('.',ft.name)=0) then concat(ft.name,'.')  else ft.name end)  else '' end) as type FROM zod01.zodCity zs left join zod01.zodFiasTypes ft on  zs.citytype_id=ft.code where cityregion_id=" . $region . "  order by name";
        $cities = DB::select($sql, []);

        echo json_encode($cities);
    }

    function getStreets($city)
    {
        //$sql = "SELECT *,zs.row_id as id,ft.name as type FROM zod01.zodCityStreet zs, zod01.zodCityStreetName zsn,zod01.zodFiasTypes ft where zs.citystreettype_id=ft.code and zs.citystreetname_id=zsn.row_id and zs.city_id=". $city;


        //$sql = "SELECT zsn.name as name, zs.row_id as id,ft.name as type FROM zod01.zodCityStreet zs, zod01.zodCityStreetName zsn,zod01.zodFiasTypes ft where zs.citystreettype_id=ft.code and zs.citystreetname_id=zsn.row_id and zs.city_id=". $city;

        header("Access-Control-Allow-Origin:*");

        $sql = "SELECT trim(zsn.name) as name, zs.row_id as id, (case when (ft.name  is not null) then (case when (locate('.',ft.name)=0) then concat(ft.name,'.')  else ft.name end)  else '' end) as type FROM zod01.zodCityStreet zs left join zod01.zodCityStreetName zsn on zs.citystreetname_id=zsn.row_id left join zod01.zodFiasTypes ft on zs.citystreettype_id=ft.code  where zs.city_id=" . $city;
        $streets = DB::select($sql, []);

        echo json_encode($streets);
    }



    function getDistricts($city)
    {
        //$sql = "SELECT *,zs.row_id as id,ft.name as type FROM zod01.zodCityStreet zs, zod01.zodCityStreetName zsn,zod01.zodFiasTypes ft where zs.citystreettype_id=ft.code and zs.citystreetname_id=zsn.row_id and zs.city_id=". $city;

        header("Access-Control-Allow-Origin:*");

        $sql = "SELECT distinct zd.name as name ,0 as id  FROM zod01.zodCityDistrict zd where zd.city_id=" . $city;
        $streets = DB::select($sql, []);

        echo json_encode($streets);
    }

    function getAreas($region)
    {

        header("Access-Control-Allow-Origin:*");
        $sql = "SELECT name, id FROM zod01.zodCityArea where region_code=" . $region . " order by name";
        $areas = DB::select($sql, []);

        echo json_encode($areas);
    }

    function getIndex($street, $house)
    {

        header("Access-Control-Allow-Origin:*");
        $sql = 'SELECT * FROM zod01.zodCityHouse where streetid=' . $street . ' and housenum="\'' . $house . '\'"';

        $areas = DB::select($sql, []);

        echo json_encode($areas);
    }
    function getByInn($inn)
    {
        $ch = curl_init();
        $headers = ['Authorization: Basic bm9yZGNvbTpub3JkY29tMjAwMg==', "Content-Type:application/json", "Content-Charset: Windows-1251", "Content-Language: ru"];
        $url =  (strlen($inn) == 10 ? "https://api.orgregister.1c.ru/rest/counter-agent/v1/find-counter-agents-by-inn?inn=" : "https://api.orgregister.1c.ru/rest/person/v1/find-person-by-inn?inn=") . $inn;






        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $res = [];

        if (strlen($inn) == 10) {
            echo "Ответ ".curl_exec($ch);
/*
            $adress = json_decode(curl_exec($ch))->corporations[0]->address;


            $res["postcode"] = isset($adress->postalCode) ? $adress->postalCode : 0;
            $res["region"] = $this->regions[$adress->areaCode * 1];
            $res["regiondistrict"] = trim((isset($adress->district) ? $adress->districtType . " " . $adress->district : "") . " " . (isset($adress->munDistrict) ? $adress->munDistrictType . " " . $adress->munDistrict : ""));
            $res["city"] = isset($adress->city) ? $adress->cityType . " " . $adress->city : "";
            $res["settlement"] = trim((isset($adress->locality) ? $adress->localityType . " " . $adress->locality : "") . " " . (isset($adress->settlement) ? $adress->settlementType . " " . $adress->settlement : "") . " " . (isset($adress->territory) ? $adress->territory : ""));
            $res["street"] =  isset($adress->street) ? $adress->streetType . " " . $adress->street : "";
            $res["house"] = isset($adress->house) ? $adress->houseType . " " . $adress->house : "";
            $res["building"] = isset($adress->buildings) ? $this->implodeAdress($adress->buildings) : "";
            $res["room"] = isset($adress->apartments) ? $this->implodeAdress($adress->apartments) : "";
            $res["adress"] = implode(',', array_filter($res, function ($item) {
                return $item != "";
            }));
            $res["regioncode"] = $adress->areaCode;
            $res["level"] = 3;
            $res["searchtype"] = 1;
            $res["returned"] = $adress;

            header("Access-Control-Allow-Origin:*");


            echo "[" . json_encode($res) . "]";*/

        } else {
            echo curl_exec($ch);
        }

        /*
        "address": {
            "fromDate": 2022-02-03",
            "valueWithPostalCode": "180502, Псковская Область, м.р-н Псковский, с.п. Тямшанская Волость, д Моглино, зона Особая Экономическая Зона Ппт Моглино, дом 67, строение 1, помещение 101",
            "munValue": "180502, Псковская Область, м.р-н Псковский, с.п. Тямшанская Волость, д Моглино, зона Особая Экономическая Зона Ппт Моглино, дом 67, строение 1, помещение 101",
            "addressType": "MUNICIPAL",
            "country": "Россия",
            "countryCode": "643",
            "postalCode": "180502",
            "area": "Псковская Область",
            "areaCode": "60",
            "munDistrict": "Псковский",
            "munDistrictType": "м.р-н",
            "settlement": "Тямшанская Волость",
            "settlementType": "с.п.",
            "locality": "Моглино",
            "localityType": "д",
            "territory": "Особая Экономическая Зона Ппт Моглино",
            "territoryType": "зона",
            "house": "67",
            "houseType": "дом",
            "buildings": [
                {
                    "type": "строение",
                    "number": "1"
                }
            ],
            "apartments": [
                {
                    "type": "помещение",
                    "number": "101"
                }
            ],
            "valid": false
        },*/
    }

    function implodeAdress($addrArray)
    {
        $res = "";
        foreach ($addrArray as $item) {
            $res .= ($res != "" ? " " : "") . $item->type . " " . $item->number;
        }
        return $res;
    }
    function notempty($item)
    {
    }
}


