

const apiroot = "http://fias.ru/public/api/"  //корень API
const priority = ["fias__index", "fias__region", "fias__city", "fias__street", "fias__house", "fias__corp", "fias__room"]

const requred = ["fias__region", "fias__city", "fias__street", "fias__house"]


let fiasdialog = false;
let regions = [];
let currentregion;

let cities = [];
let currentcity;

let streets = [];
let currentstreet;


let fiasreturn = ""
let fiasready = false;



let apioptions
let teststr = "startok"




const buildfiasDialog = (target) => {
    if (!fiasdialog) {

        $(target).append('<div class="fias__container modal" style="display:none"><div class="fias__index"><div class="title">Индекс</div>        <div class="input noselect"><input type="text" name="" id=""></div>    </div>    <div class="fias__region">        <div class="title">Регион</div>        <div class="input"><input type="text" name="" id="fias__region"></div>        <div class="select">..</div>    </div>    <div class="fias__city blocked">        <div class="title">Город</div>        <div class="input"><input type="text" name="" id="fias__city"></div>        <div class="select">..</div>    </div>    <div class="fias__street blocked">        <div class="title">Улица</div>        <div class="input"><input type="text" name="" id="fias__street"></div>        <div class="select">..</div>    </div>    <div class="fias__house blocked">        <div class="title">Дом</div>        <div class="input noselect"><input type="text" name="" id="fias__house"></div>    </div>    <div class="fias__corp blocked">        <div class="title">Корпус</div>        <div class="input noselect"><input type="text" name="" id="fias__corp"></div>    </div>    <div class="fias__room blocked">        <div class="title">Квартира</div>        <div class="input noselect"><input type="text" name="" id="fias__room"></div>    </div><div class="fias__footer"></div></div><div class="fias__popup"  style="display:none"><div class="fias__popupdata"></div><div class="fias__popupfooter"></div></div>')


        ////////////выбор регоина
        $(".fias__region").children(".select").click(function () {

            displayPopup($(".fias__region").children(".input").children("input"), regions, "name", [{ type: "unblock", target: ".fias__city" }, { type: "blockafter", target: ".fias__city" }, { type: "execute", target: getCities.bind(teststr), data: teststr }])

        })

        ////////////выбор города
        $(".fias__city").children(".select").click(function () {

            displayPopup($(".fias__city").children(".input").children("input"), cities, "name", [{ type: "unblock", target: ".fias__street" }, { type: "blockafter", target: ".fias__street" }, { type: "execute", target: getStreets }])

        })


        ////////////выбор улицы
        $(".fias__street").children(".select").click(function () {

            displayPopup($(".fias__street").children(".input").children("input"), streets, "name", [{ type: "unblock", target: ".fias__House" }, { type: "blockafter", target: ".fias__house" }])

        })



    }


}

const displayfiasDialog = (target, options = {}) => {

    apioptions = options;
    buildfiasDialog(target);



    $(".fias__footer").html("");
    options.actions.map((action, index) => {
        if (action.type == "button") {
            $(".fias__footer").append('<div class="btn" id="btn' + index + '">' + action.text + '</div>')
            $(".fias__footer").children("#btn" + index).click(function () {

                if (action.action) action.action(returnFias());

                if (action.hide)
                    $(".fias__container").fadeOut();
            })
        }
    })


    $(".fias__container").fadeIn();



    getRegions()




}


const getRegions = () => {
    fetch(apiroot + "regions").then(items => {
        if (items.status >= 200 && items.status < 300) {
            items.json().then(
                items => {
                    regions = items
                    let text = ""
                    if (apioptions.defaultRegion) {
                        debugger
                        text = regions.find(
                            item => {
                                item.code * 1 == apioptions.defaultRegion
                            }) ? regions.find(
                                item => {
                                    item.code * 1 == apioptions.defaultRegion
                                }).name : regions[0].name;
                    }
                    else {
                        text = regions[0].name
                    }
                    //  $("#fias__region").val(text)

                }
            ), err => alert("Ошибка получения данных! Проверьте настройки переменной apiroot в модуле fiasdialog.js. Текущий путь: " + apiroot)
        }
        else { alert("Ошибка получения данных! Проверьте настройки переменной apiroot в модуле fiasdialog.js. Текущий путь: " + apiroot) }

    })
}

const displayPopup = (target, data, name = "name", actions = [], id = "row_id") => {


    $(".fias__popup").fadeIn();
    $(".fias__popup").html("");

    data.map((item, index) => {
        // alert(item[name])
        $(".fias__popup").append('<div class="fias__popupitem" id="fias__popupitem' + index + '">' + item[name] + '</div>')

        $("#fias__popupitem" + index).click(function () {

            $(target).val($(this).html())
            actionExec(actions, item[id])
            $(".fias__popup").fadeOut();
        })

    })

}


const actionExec = (actions, id = -1) => {
    actions.map(action => {
        switch (action.type) {
            case "unblock":
                $(action.target).removeClass("blocked")
                $("#"+action.target.replace(".","")).val("")
                break;


            case "blockafter":
                debugger;
                const index = priority.findIndex(item => ("."+item) == action.target)
                if (index != -1) {
                    for (t = index + 1; t<=priority.length - 1; t++) {
                        $("."+priority[t]).addClass("blocked")
                        $("#"+priority[t]).val("");
                    }
                }
                break;


            case "execute":

                action.target(id);


                break;


        }



    })


}


const getCities = (data) => {
    fetch(apiroot + "cities/" + data).then(items => {
        if (items.status >= 200 && items.status < 300) {
            items.json().then(
                items => {
                    cities = items
                    let text = ""
                    text = cities[0].name
                    //  $("#fias__city").val(text)

                })
        }
        else { alert("Ошибка получения данных! Проверьте настройки переменной apiroot в модуле fiasdialog.js. Текущий путь: " + apiroot) }
    })

}



const getStreets = (data) => {
    fetch(apiroot + "streets/" + data).then(items => {
        if (items.status >= 200 && items.status < 300) {
            items.json().then(
                items => {
                    streets = items
                    let text = ""
                    text = streets[0].name
                    //    $("#fias__street").val(text)

                })
        }
        else { alert("Ошибка получения данных! Проверьте настройки переменной apiroot в модуле fiasdialog.js. Текущий путь: " + apiroot) }
    })

}


const returnFias=()=>{
 
    return requred.filter(item=>$((".")+item).val()!="").lemgth==requred.lemgth?requred.map((item,index)=>$(("#")+item).val()):false;


}