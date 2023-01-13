root = "http://fias.ru/public/api/";
let adresses;

let startheight = ($("body").outerHeight() - 150) / 2
let endheight = 100;
let searchcollapsed = false;
let searchcollapseTimer
///////////////////startup////////////////////////////



$(function () {
    $(".searchbutton").click(function () {
        alert("")
        fetch(root + "search/" + $("#searchtext").val()).then(
            res => res.json().then(
                res => {
                    adresses = res
                    collapseSearch()
                    buildAdresses(".adresses")



                }

            ))


    })

})




///////////////////////////main logic/////////////////


let buildAdresses = (target) => {
    $(target).html('');

    adresses.map(adress => {
        if (adress.fulladress) {
            searchtype={ "1": " По индексу", "10": "По городу","11": "По индексу и городу","100": "По улице" ,"101": "По индексу и улице","110": "По городу и улице","111": "По индексу, городу и улице"   }[adress.searchtype]
            $(target).append('<div class="adresscontainer"><div class="adresscontainer__type">' +(searchtype?searchtype:adress.searchtype)  + '</div>  <div class="adresscontainer__adress">' + adress.fulladress.split($("#searchtext").val()).join('<div class="highlighter">' + $("#searchtext").val() + "</div>") + '</div></div>')
        }
    })


}


let collapseSearch = () => {
    if (!searchcollapsed) {
        searchcollapseTimer = setInterval("collapser", 100)
    }
    else {
        clearInterval(searchcollapseTimer)
    }
}


let collapser = () => {
    if (startheight - 1 > endheight) {
        startheight = startheight - 1
        $("body").css({ "grid-template-rows": startheight + "px 1fr" })

    }
    else {

        clearInterval(searchcollapseTimer)
    }


}

