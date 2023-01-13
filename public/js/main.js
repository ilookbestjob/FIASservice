let root = "http://fias.ru/";
let regions = {
  "1": "Республика Адыгея",
  "4": "Республика Алтай",
  "2": "Республика Башкортостан",
  "3": "Республика Бурятия",
  "5": "Республика Дагестан",
  "6": "Республика Ингушетия",
  "7": "Кабардино-Балкарская республика",
  "8": "Республика Калмыкия",
  "9": "Карачаево-Черкесская республика",
  "10": "Республика Карелия",
  "11": "Республика Коми",
  "91": "Республика Крым",
  "12": "Республика Марий Эл",
  "13": "Республика Мордовия",
  "14": "Республика Саха (Якутия)",
  "15": "Республика Северная Осетия — Алания",
  "16": "Республика Татарстан",
  "17": "Республика Тыва",
  "18": "Удмуртская республика",
  "19": "Республика Хакасия",
  "20": "Чеченская республика",
  "21": "Чувашская республика",
  "22": "Алтайский край",
  "75": "Забайкальский край",
  "41": "Камчатский край",
  "23": "Краснодарский край",
  "24": "Красноярский край",
  "59": "Пермский край",
  "25": "Приморский край",
  "26": "Ставропольский край",
  "27": "Хабаровский край",
  "28": "Амурская область",
  "29": "Архангельская область",
  "30": "Астраханская область",
  "31": "Белгородская область",
  "32": "Брянская область",
  "33": "Владимирская область",
  "34": "Волгоградская область",
  "35": "Вологодская область",
  "36": "Воронежская область",
  "37": "Ивановская область",
  "38": "Иркутская область",
  "39": "Калининградская область",
  "40": "Калужская область",
  "42": "Кемеровская область",
  "43": "Кировская область",
  "44": "Костромская область",
  "45": "Курганская область",
  "46": "Курская область",
  "47": "Ленинградская область",
  "48": "Липецкая область",
  "49": "Магаданская область",
  "50": "Московская область",
  "51": "Мурманская область",
  "52": "Нижегородская область",
  "53": "Новгородская область",
  "54": "Новосибирская область",
  "55": "Омская область",
  "56": "Оренбургская область",
  "57": "Орловская область",
  "58": "Пензенская область",
  "60": "Псковская область",
  "61": "Ростовская область",
  "62": "Рязанская область",
  "63": "Самарская область",
  "64": "Саратовская область",
  "65": "Сахалинская область",
  "66": "Свердловская область",
  "67": "Смоленская область",
  "68": "Тамбовская область",
  "69": "Тверская область",
  "70": "Томская область",
  "71": "Тульская область",
  "72": "Тюменская область",
  "73": "Ульяновская область",
  "74": "Челябинская область",
  "76": "Ярославская область",
  "77": "Москва",
  "78": "Санкт-Петербург",
  "92": "Севастополь",
  "79": "Еврейская автономная область",
  "83": "Ненецкий автономный округ",
  "86": "Ханты-Мансийский автономный округ - Югра",
  "87": "Чукотский автономный округ",
  "89": "Ямало-Ненецкий автономный округ"
}

let totalErrs = 0;


let selected = [10]
let uploadtypes = [3]
$(function () {
  $("#upload").click(function () {
    $(".file").click()
  })





  $(".file").change(function () {
    if ($(this).val() != "") {
      sendFile();
    }
  });
  selected = [10]
  setInterval("check()", 10);

  $("#stop").click(function () { fetch(root + "public/upload/manage/stop") })
  $("#region").click(function () {
    buildRegions(".popupdata");
    $(".popup").fadeIn();
    $(".popup").css("display", "grid")
  })
  $("#closepopup").click(function () {
    $(".popup").fadeOut();
    console.log("close", selected)
    prepareDemoregions()
    $(".popup").fadeOut();
    console.log("closeafter", selected)
    buildDemoRegions(".regions", selected)
  })


  $("#fromuploaded").click(function () {

    (async () => {
      const rawResponse = await fetch(root + 'public/upload/fromuploaded', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': $("#csrf-token").val()
        },
        body: JSON.stringify({ selected: selected, uploadtypes: uploadtypes })
      });
      const content = await rawResponse.json();
      console.log(content);
    })();

  })


  $(".tcontent").children("input").click(function () {

    uploadtypes = [];

    $(".tcontent").children("input").each(function () {
      if ($(this).is(":checked")) {
        uploadtypes.push($(this).attr("id"))
      }
    })

  })



  setCheckboxes()
})


const setCheckboxes = () => {


  $(".tcontent").children("input").attr("checked", false)
  uploadtypes.forEach((item) => {
    $(".tcontent").children("#" + item).attr("checked", true)

  });


}


const check = () => {
  fetch(root + "storage/app/manage/pending.txt").then(res => {
    if (res.ok) {
      res.text().then(res => {
        console.log(res);

        totalErrs = 0;
        data = res.split("/")

        $(".progressinfo").fadeIn();
        $(".uploadsetup").fadeOut();

        $("#regionsprogressinfo").children(".info").html("Обший прогресс")
        $("#baseprogressinfo").children(".info").html(data[1] + '. ' + regions[data[1] * 1 + ""] + " (" + data[4] + " из " + (data[5] == "" ? "неизвестно " : data[5]) + ")")
        //$("#fileform").fadeOut();
        //$("#upload").fadeOut();
        $("#uploadtext").fadeOut();
        $("#regionsprogressinfo").children(".progressbarcontainer").children(".progressbar").css("width", (data[1] / data[2]) * 100 + "%")

      }
      )
    } else {
      totalErrs++;
      if (totalErrs > 10) {
        buildDemoRegions(".regions", selected)
        $(".progressinfo").fadeOut();
        $(".uploadsetup").fadeIn();
      }

    }
  })


}



const sendFile = () => {
  let input = document.querySelector('input[type="file"]');

  let data = new FormData();
  data.append("file", input.files[0]);
  data.append("action", "uploadbook");

  fetch("http://fias.ru/public/upload/file", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": $('input[name="_token"]').val()
    },
    method: "POST",
    body: data,
  })
    .then((res) => res.text())
    .then((res) => {


    });
};


const buildRegions = (target) => {
  $(target).html("");
  for (region in regions) {
    $(target).append('<div class="regiontoselect' + (selected.find(item => item == region) ? " checked" : "") + '"  id="' + region + '" ><div class="check" ><input type="checkbox"  ' + (selected.find(item => item == region) ? "checked" : "") + '/></div><div class="text">' + regions[region] + '</div></div>');



  }



  $(".regiontoselect").click(function () {

    console.log($(this).children(".check").children("input"))
    if ($(this).children(".check").children("input").is(':checked')) {
      $(this).addClass("checked")

    }
    else { $(this).removeClass("checked") }
  })

}

const prepareDemoregions = () => {
  selected = [];
  $(".regiontoselect").each(function () {

    if ($(this).children(".check").children("input").is(':checked')) { selected.push($(this).attr("id")) }

  })

  console.log(selected)

}

const buildDemoRegions = (target, selected = [10, 23, 34, 22, 1, 22, 3, 55, 7, 8, 9], quantity = 9) => {
  $(target).html("");
  for (t = 0; t < (quantity >= selected.length ? selected.length : (quantity)); t++) {
    $(target).append("<div class='demoregion'>" + (regions[selected[t]].length <= 15 ? regions[selected[t]] : regions[selected[t]].substr(0, 15) + "..") + "</div>");
  }
  $(target).append("<div class='regionsleft'>" + ((selected.length > quantity) ? "еще " + (selected.length - quantity) : "") + "</div>");
}
