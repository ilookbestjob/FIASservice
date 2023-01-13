<?



set_time_limit (0);
ini_set('max_execution_time', 0);
ignore_user_abort(true);
ini_set('memory_limit', '2200M');

ini_set('error_reporting',E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$session="";
$glInn="1001136430";
$glKpp="100101001";

if(!isset($_GET['k'])) exit;
if ($_GET['k']!="lK_wh__rFg2") exit;

header('Content-type: text/html; charset=utf-8');

$deb=0;
if (isset($_GET['deb'])) $deb=intval($_GET['deb']);

//if ($deb!=0){
  //  file_put_contents("test.txt", "test", FILE_APPEND);
//    echo "!!!!!";
    //exit;
//}

//echo dirname(__FILE__);
//exit;

//Список идентификаторов 
// https://1c-edo.ru/handbook/22/2668/

//Проверка на Госуслугах
//https://www.gosuslugi.ru/pgu/eds

//Версия
// /opt/cprocsp/bin/amd64/csptestf -enum -info
// /opt/cprocsp/bin/amd64/cryptcp --version
// cat /etc/opt/cprocsp/release

// Срок дейсвия лицензии
// /opt/cprocsp/sbin/amd64/cpconfig -license -view
// /opt/cprocsp/sbin/amd64/cpconfig -license -set ЧЧЧ-ЧЧ-ЧЧЧ-ЧЧ-ЧЧ

///Список сертификатов. SHA1 - отпечаток
//  /opt/cprocsp/bin/amd64/certmgr -list -cert -store uMy  
//$signing = shell_exec($this->cryptcp_prefix."cryptcp -sign -der -strict -cert -detached -thumbprint ".$this->thumbprint." ".$file_msg."");


// Подписать ЭП
// /opt/cprocsp/bin/amd64/cryptcp -sign -thumbprint 810BFE997DC8C48E6079C15CC27A7A39367EFEE4 -detach -der file file_out -nochain -norev
// /opt/cprocsp/bin/amd64/csptest -sfsign -sign -in  -out -my '' -detached  
// /opt/cprocsp/bin/amd64/csptest -sfsign -sign -in  -out -my 'Сертификат' -detached -addsigtime -base64 -add
// /opt/cprocsp/bin/amd64/cryptcp -signf -thumbprint 810BFE997DC8C48E6079C15CC27A7A39367EFEE4 -detach -der file file_out -nochain -norev

// /opt/cprocsp/bin/amd64/csptest -sfsign -sign GOST12_256 -in ON_NSCHFDOPPR_2BE806b135aba9511e187a55cf3fc3369f0_2AL-18DC3D87-B414-471B-9B58-D51485D2F072-00000_20220322_257a7eb7-f747-4961-99b3-d05c15dc70f6.xml.hsh -out sign0.sgn -my '' -detached -addsigtime -add

// /opt/cprocsp/bin/amd64/csptest -csp "Crypto-Pro GOST R 34.10-2012 Cryptographic Service Provider" -csptype 80 -container "REGISTRY\\35343565455235" -hash BD9882FF237B8471E548EB86D9311A462BBA055519425B5F5E1A783FA023AD72 -out 'file.sign'

//получить криптографический хеш-вложения
// /opt/cprocsp/bin/amd64/cpverify -mk -alg GR3411_2012_256
// /opt/cprocsp/bin/amd64/cryptcp -hash -hex -hashAlg 1.2.643.7.1.1.2.2 -provtype 75 

//Сборка phpcades
// 
// в файле Makefile.unix после -fPIC -DPIC добавьте -fpermissive

//Установка Рутокена
//
// lsusb
// dpkg –i cprocsp-rdr-pcsc
// dpkg –i cprocsp-rdr-rutoken
// /opt/cprocsp/bin/amd64/list_pcsc
// /opt/cprocsp/bin/amd64/csptest -keyset -enum_cont -fqcn -verifyc
// /opt/cprocsp/sbin/amd64/cpconfig -hardware reader -view
// Добавляем сертификат:
// /opt/cprocsp/bin/amd64/csptestf -absorb -cert
// Удалить сертификаты
// /opt/cprocsp/bin/amd64/certmgr -delete


//Если отваливается при подписи
// /opt/cprocsp/sbin/amd64/cpconfig -ini '\cryptography\apppath' -add string 'libcurl.so' /usr/lib/x86_64-linux-gnu/libcurl.so.4

  
include ('../../zod.conf.php');
include ('../../zod.conf.local.php');



$action=0;
if (isset($_GET['a'])) $action=intval($_GET['a']);



$zod0x=mysqli_connect($zodConf[$zodLocal]['ip'], $zodConf[$zodLocal]['user'], $zodConf[$zodLocal]['pass'],'zod0'.$zodLocal);
mysqli_query($zod0x,"set names utf8mb4");



if ($action==1) {
    getResourceFile($_GET['doc'],$_GET['id']);    
    exit;
    }

if ($action==2) {    
    docConfirm($_GET['doc'],$_GET['id'],$_GET['sert'],$_GET['p']);
    echo "OK";
    exit;
}
if ($action==3) {
    if (!isset($_GET['inn'])) exit;
    $inn=$_GET['inn'];
    $kpp="";
    if (isset($_GET['kpp'])) $kpp=$_GET['kpp'];            
    companyIdetifier($inn,$kpp);
    exit;
}

if ($action==4) {
    if (!isset($_GET['doc'])) exit;
    docCreate($_GET['doc']);
    exit;
    }

if ($action==5) {
    if (!isset($_GET['doc'])) exit;
    docUpdate($_GET['doc']);
    exit;
    }    


if ($action==6) {
    if (!isset($_GET['p'])) exit;
    docListSert($_GET['p']);
    exit;
    }     


$fp = fopen("zodsbis.lock", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) { 


    //$param=[
            //"Параметр"=>[]
    //];
    //$ret=excuteCommand("СБИС.ИнформацияОВерсии", $param);
    //print_r($ret);
    //echo date("d.m.Y",strtotime("-7 day"));
    //exit;

    //$param=[
    //    "Фильтр"=>[
    //    "ДатаС"=>date("d.m.Y",strtotime("-7 day")),
    //    "Тип"=>"ФактураВх"
    //    ]
    //];
    //$ret=excuteCommand("СБИС.СписокДокументов", $param);
    //print_r($ret);

    //$param=[
    //   "Фильтр"=>[
    //       "ТолькоНаличиеСобытий"=>"Да"
    //    ]
    //];
    //$ret=excuteCommand("СБИС.ИнформацияОСлужебныхЭтапах", $param);
    //print_r($ret);    


    if (1==1) {
        docList("Входящие",3);
        docList("Отправленные",3);
        }
        //-------------------------------------------------------

    if (1==1){
        //--------------------Статус-----------------------------
        $sql="select row_id, identifier 
        from zodEdo 
        where zodEdo.zod=".intval($zodLocal)." 
        and not exists(select * from zodEdoStatus where zodEdoStatus.zod=zodEdo.zod and zodEdoStatus.zodEdo_id=zodEdo.row_id and zodEdoStatus.zodEdoStatusName_id=6 and zodEdo.confirmation=1)
        and not exists(select * from zodEdoStatus where zodEdoStatus.zod=zodEdo.zod and zodEdoStatus.zodEdo_id=zodEdo.row_id and zodEdoStatus.zodEdoStatusName_id=2 and zodEdo.confirmation=0)        
        order by zodEdo.zodDocStatusUpdate limit 100";
        $sqlm=mysqli_query($zod0x,$sql);
        while ($sqlmg=mysqli_fetch_array($sqlm)){
            $edo_id=$sqlmg['row_id'];
            $doc_identifier=$sqlmg['identifier'];
            $param=[
                "Документ"=>[
                "Идентификатор"=>$doc_identifier,
                "ДопПоля"=>"ДополнительныеПоля"
                ]
            ];
            $ret=excuteCommand("СБИС.ПрочитатьДокумент", $param);
            if (isset($ret->result)) docUpdateEvent($ret->result, $edo_id);
        }
        //---------------------------------------
    }
    
    echo "OK";
    get_headers("http://725522.ru/sys/const.php?a=1&id=95&asdkjwerjawrkgjasflkasfjkl=1&rnd=".rand());
    flock($fp, LOCK_UN);

} else {
    echo "Обработка уже запущенна";
    exit;
}

fclose($fp);
unlink("zodsbis.lock");



//--------------------------------------
function excuteCommand($method, $params, $init=false){
//global $session;

    if ($init==false) {
            $url="https://online.sbis.ru/service/?srv=1";
            login();
        }
        else $url="https://online.sbis.ru/auth/service/";
    
    $param=[
        "jsonrpc"=>"2.0",
        "method"=>$method,
        "params"=>$params,
        "id"=>0
    ];

    $data = json_encode($param);
    $result=curlGet($url,$data);
    $result=json_decode($result);
    return $result;
}
//--------------------------------------
function curlGet($url,$data){
global $session;
    try {
        $header=["Content-Type: application/json;charset=utf-8"];
        if ($session!="") $header[]="X-SBISSessionID: ".$session;    
        $ch=curl_init();
        $timeout=10000;
        //print_r($header);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,99999999999999999);    
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result=curl_exec($ch);
        curl_close($ch);
    } catch (Exception $e) {
        $result="#ERR: CURL: ".$e->getMessage();
        $result="";    
    }        
    return $result;
}
//--------------------------------------
function curlGet2($url,$data=""){
        $ch=curl_init();
        $timeout=15;
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);    
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($data!=""){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
//--------------------------------------
function curlGetHeader($url,$data=""){
    $ch=curl_init();
    $timeout=15;
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);    
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($data!=""){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $result=curl_exec($ch);
    $info = curl_getinfo($ch);
    $header_size=$info['header_size'];
    $actualResponseHeaders = substr($result, 0, $header_size);
    curl_close($ch);
    $result=substr($result, $header_size);
    return ["data"=>$result,"header"=>$actualResponseHeaders];
}
//--------------------------------------
function docUpdateEvent($ret, $doc){
global $zod0x,$glInn,$glKpp,$zodLocal;
    $confirm=0;
    if (isset($ret->Этап[0]->Название)) $confirm=1;

    if (isset($ret->Событие)){
        foreach ($ret->Событие as $z){        
            $name=$z->Название;
            //echo $name."<br>";
            $identifier=$z->Идентификатор;
            $inout=-1;
            $system=-1;
            if (isset($z->Вложение)){
                $inout=0;
                $system=0;                
                if ($z->Вложение[0]->Направление!="Входящий") $inout=1;            
                if ($z->Вложение[0]->Служебный!="Нет") $system=1;
            }

            $data=$z->ДатаВремя;
            //echo $data." [".$inout."] [".$system."]: ".$name;

            

            $sql="select row_id from zodEdoStatusName where name='".$name."'";
            $sql=mysqli_query($zod0x,$sql);
            $sqlg=mysqli_fetch_array($sql);

            if (isset($sqlg['row_id'])) {
                $name_id=$sqlg['row_id'];
            }
            else {
                $sql="insert into zodEdoStatusName set name='".$name."'";
                $sql=mysqli_query($zod0x,$sql);
                $name_id=mysqli_insert_id($zod0x);
            }

            if ($name_id==3 || $name_id==7) $confirm=1; 

            $sql="select identifier from zodEdoStatus where zod=".intval($zodLocal)." and zodEdo_id=".intval($doc)." and identifier='".inputclean($identifier)."'";
            //echo $sql;
            $sql=mysqli_query($zod0x,$sql);
            $sqlg=mysqli_fetch_array($sql);

            if (!isset($sqlg['identifier'])) {
                $sql="insert into zodEdoStatus set zod=".intval($zodLocal).", zodEdo_id=".intval($doc).", identifier='".inputclean($identifier)."'
                , `inout`=".intval($inout).", data='".toDate($data)."', system=".intval($system).", zodEdoStatusName_id=".intval($name_id);
                //echo $sql;
                $sql=mysqli_query($zod0x,$sql);
            }
            //exit;

            //echo "<br>";
        }
    }

    $sql="update zodEdo set zodDocStatusUpdate=now(), confirmation=confirmation || ".intval($confirm)." where zod=".intval($zodLocal)." and row_id=".intval($doc);
    //echo $sql;
    //exit;
    $sql=mysqli_query($zod0x,$sql);       
}
//--------------------------------------
function docList($folder,$days=14){
global $zod0x,$glInn,$glKpp,$zodLocal;
    $page=0;
    while ($page<500){
        //--------------------Документы-----------------------------  
        //"ДатаС"=>date("d.m.Y",strtotime("-14 day")),              
        $param=[
            "Фильтр"=>[
                //"ДатаС"=>"01.02.2019",
                //"ДатаПо"=>"01.10.2020",
                "ДатаС"=>date("d.m.Y",strtotime("-".$days." day")),                                  
                "ТипРеестра"=>$folder,
                "НашаОрганизация"=>[
                    "СвЮЛ"=>[
                        "ИНН"=>$glInn,
                        "КПП"=>$glKpp
                    ]
                ],  
                "Навигация"=>[
                    "РазмерСтраницы"=>25,
                    "Страница"=>$page
                ]
            ]
        ];
        $page++;

        print_r($param);
        //exit;
        $ret=excuteCommand("СБИС.СписокДокументовПоСобытиям", $param);
        

        //print_r($ret);
        //exit;
        foreach ($ret->result->Реестр as $z){
            $retdoc=docGet($z->Документ->Идентификатор);
            //print_r($retdoc);
            docUpdateSys($retdoc->result);
            //exit;            
        }
        if ($ret->result->Навигация->ЕстьЕще=="Нет") return;
        //print_r($ret);
    }
    exit;
}
//--------------------------------------
function getResourceArch($url,$identifier,$modify=false){
    global $session;
        
        $dir=dirname(__FILE__) . '/archive/';
        //echo $dir;
        $folder=substr($identifier,0,strpos($identifier,"-"));
        if (is_dir($dir."".$folder)===false) {
            mkdir($dir."".$folder, 0777);
            //echo $dir."".$folder;
        }


        if (file_exists($dir.$folder."/".$identifier.".zip")) {
            if ($modify==false) return;
            $i=0;
            while(file_exists($dir.$folder."/".$identifier."_".$i.".zip")) $i++;
            rename ($dir.$folder."/".$identifier.".zip", $dir.$folder."/".$identifier."_".$i.".zip");
        }
        
        //echo "!!!!!!!";

        $fn=$identifier.".zip";

        $file = fopen ($dir.$folder."/".$fn, 'w+');
        $header=["Content-Type: application/json;charset=utf-8"];
        $header[]="X-SBISSessionID: ".$session;
        //print_r($header);
        $ch=curl_init();
        $timeout=30;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);    
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FILE, $file); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);        
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
//-------------------------------
function toDate($str) {
    if ($str=="") return "'+null+'";
    if (strpos($str," ")!==false) $a=explode(".",substr($str,0,strpos($str," ")));
        else  $a=explode(".",$str);
    $ret="".$a[2].".".$a[1].".".$a[0];
    if (strpos($str," ")!==false) $ret.=" ".str_replace(".",":",substr($str,strpos($str," ")));
    //$ret=substr($str,0,strpos($str," "))." ".str_replace(".",":",substr($str,strpos($str," ")));

    return $ret;
}
//-------------------------------
function inputclean($str) {
    global $zod0x;
        $str=preg_replace("[^-a-zA-Zа-яА-ЯёЁ0-9/., @#'():]", "", $str);
        $str=mysqli_real_escape_string($zod0x, $str);
        return $str;        
}
//-------------------------------
function zipError($code){
                switch ($code)
                    {
                        case 0:
                        return 'No error';
                       
                        case 1:
                        return 'Multi-disk zip archives not supported';
                       
                        case 2:
                        return 'Renaming temporary file failed';
                       
                        case 3:
                        return 'Closing zip archive failed';
                       
                        case 4:
                        return 'Seek error';
                       
                        case 5:
                        return 'Read error';
                       
                        case 6:
                        return 'Write error';
                       
                        case 7:
                        return 'CRC error';
                       
                        case 8:
                        return 'Containing zip archive was closed';
                       
                        case 9:
                        return 'No such file';
                       
                        case 10:
                        return 'File already exists';
                       
                        case 11:
                        return 'Can\'t open file';
                       
                        case 12:
                        return 'Failure to create temporary file';
                       
                        case 13:
                        return 'Zlib error';
                       
                        case 14:
                        return 'Malloc failure';
                       
                        case 15:
                        return 'Entry has been changed';
                       
                        case 16:
                        return 'Compression method not supported';
                       
                        case 17:
                        return 'Premature EOF';
                       
                        case 18:
                        return 'Invalid argument';
                       
                        case 19:
                        return 'Not a zip archive';
                       
                        case 20:
                        return 'Internal error';
                       
                        case 21:
                        return 'Zip archive inconsistent';
                       
                        case 22:
                        return 'Can\'t remove file';
                       
                        case 23:
                        return 'Entry has been deleted';
                       
                        default:
                        return 'An unknown error has occurred('.intval($code).')';
                    }    
}      
//-------------------------------
function getResourceFile($doc,$identifier,$isPDF=true){
global $zod0x, $zodLocal;
    $sql="select zodEdo.identifier, zodEdoResource.fileName from zodEdo, zodEdoResource where zodEdo.zod=".intval($zodLocal)." and zodEdo.row_id=".intval($doc)." and zodEdoResource.zodEdo_id=zodEdo.row_id and zodEdoResource.zod=zodEdo.zod and zodEdoResource.identifier='".inputclean($identifier)."'";
    //echo $sql;
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);
    if (!isset($sqlg['identifier'])) {echo "#ERR: Неверный id документа или идентификатор. ID:".$doc." Identifier:".$identifier; exit;}
    $fn=$sqlg['identifier'];
    $res_fn=$sqlg['fileName'];
    //echo $fn;

    $dir=dirname(__FILE__) . '/archive/';
    //echo $dir;
    $folder=substr($fn,0,strpos($fn,"-"));
    if (!file_exists($dir.$folder."/".$fn.".zip")) {
        echo "#ERR: Файл не найден: ".$dir.$folder."/".$fn.".zip"; 
        exit;
    }


    //phpinfo();
    setlocale(LC_ALL, "ru_RU.CP866");
    $zip = new ZipArchive();
    $opened=$zip->open($dir.$folder."/".$fn.".zip");
    if($opened !== true ){     
        echo "#ERR: ".zipError($opened);
        exit;
    }

    if ($isPDF==true) $pdf="PDF/".substr($res_fn,0,strrpos($res_fn,".")).".pdf";
        else $pdf=$res_fn;


    for ($i = 0; $i < $zip->numFiles; $i++) {
        $zipname=$zip->getNameIndex($i, \ZipArchive::FL_ENC_RAW);
        $zipname=mb_convert_encoding($zipname,'utf-8','CP866');
        //echo $zipname."<br>";
        if ($zipname==$pdf){
            if ($isPDF==true) {
                header("Content-type:application/pdf");
                header("Content-Disposition:attachment;filename=\"".$pdf."\"");
                echo $zip->getFromIndex($i);
            }
            else return $zip->getFromIndex($i);
            
            exit;
        }
        //echo $test."<br>";
        //$zip->extractTo($dir,array($test));

        //
        //echo $content;

    }

    //$res_fn=mb_convert_encoding($res_fn,'CP866','utf-8');
    
    echo "#ERR: Файл '".$pdf."' не найден в архиве: ".$dir.$folder."/".$fn.".zip"; 
    exit;
    
    //echo $pdf;

    //echo "!".$zip->locateName($pdf);

    //$zip->extractTo($dir."/temp/", array('PDF/'.$pdf));
    //echo $dir;
    //$zip->extractTo($dir);

    if (!$zip->extractTo($dir,array('PDF/'.$pdf))) {echo "#ERR: Файл не найден в архиве: PDF/".$pdf; exit;}
    $zip->close();


    readfile($dir.'PDF/'.$pdf);


}
//-------------------------------
function docConfirm($doc,$identifier,$sert=0,$p=""){
    global $zod0x, $zodLocal;
    $sql="select zodEdo.identifier from zodEdo where zodEdo.zod=".intval($zodLocal)." and zodEdo.row_id=".intval($doc)." and zodEdo.identifier='".inputclean($identifier)."'";
    //echo $sql;
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);
    if (!isset($sqlg['identifier'])) {echo "#ERR: Неверный id документа или идентификатор"; exit;}


    $sql="select zodAuthor.inn, zodAuthor.firstName, zodAuthor.lastName, zodAuthor.patronymic, zodEdoSertificate.thumbprint from zodAuthor, zodEdoSertificate where zodEdoSertificate.zod=".intval($zodLocal)." and zodEdoSertificate.id=".intval($sert)." 
    and zodEdoSertificate.zodAuthor=zodAuthor.inn and zodEdoSertificate.isActive=1 and zodEdoSertificate.del=0";
    //echo $sql;
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);
    if (!isset($sqlg['inn'])) {echo "#ERR: Неверный id сертификата"; exit;}    
    $inn=$sqlg['inn'];
    $fio=$sqlg['firstName']." ".$sqlg['lastName']." ".$sqlg['patronymic'];
    $thumbprint=$sqlg['thumbprint'];

    $ret=docGet($identifier);
    if (!isset($ret->result)){
        echo "#ERR: СБИС.ПрочитатьДокумент не вернул данные";
        exit;
    }

    //https://sbis.ru/help/integration/catalog/guide#2

    //print_r($ret);
    $stepName=$ret->result->Этап[0]->Название;
    //echo $stepName;
    //exit;
    $stepName2="";
    if ($stepName=="Сверить") $stepName2="Утверждено";
    if ($stepName=="Утверждение") $stepName2="Утвердить";

    //print_r($ret);
    //docUpdateSys($ret->result);
    //exit;

    //echo $dir;

    $param=[
            "Документ"=>[
               "Идентификатор"=>$identifier,
               "Этап"=>[
                  "Действие"=>[
                     "Название"=>$stepName2,
                     "Сертификат"=>[
                         //"ФИО"=>$fio,
                         //"ИНН"=>$inn
                        "Отпечаток"=>$thumbprint
                     ]
               ],
               "Название"=>$stepName
            ]
        ]
    ];
    $ret=excuteCommand("СБИС.ПодготовитьДействие", $param);    
    if (isset($ret->error)){
        echo "#ERR1: ".$ret->error->message;
        exit;
    }
    
    if (!isset($ret->result)){
        echo "#ERR: СБИС.ПодготовитьДействие не вернул данные";
        exit;
    }

    $param=[
        "Документ"=>[
            "Идентификатор"=>$identifier,
            "Этап"=>[
                "Вложение"=>[],
                "Действие"=>[
                    "Название"=>$stepName2
                ],
                "Название"=>$stepName
            ]
            //"ДопПоля": "ДополнительныеПоля"
        ]
    ];

    //print_r($ret->result);
    //echo "<br>";
    $resno=0;
    foreach ($ret->result->Этап[0]->Вложение as $z){
        //if ($z->Служебный=="Да") continue;

        $fn=$z->Файл->Имя;
        $hash=$z->Файл->Хеш;
        $hashHex=bin2hex(base64_decode($z->Файл->Хеш));
        //echo $fn."<br>Хеш: ".$hash."<br>hex: ".strtoupper($hashHex)."<br><br>";        
        $fn=$z->Файл->Имя;
        $link=$z->Файл->Ссылка;


        $data=strtoupper($hashHex);

        //$data=getResourceFile($doc, $z->Идентификатор,false);
        //echo $data;
        //echo $link."<br>";
        
        //$data=curlGet2($link);
        //echo base64_encode($data);
        //echo $data;
        //exit;
        


        //https://sso.sbis.ru/a-auth/?ret=disk%2Esbis%2Eru%2Fdisk%2Fapi%2Fv1%2Fda4ac3aa%2D80f3%2D4d68%2D8dbe%2D312f384dd6a6%5F8b96b5eb%2D056b%2D4f83%2D831e%2D9a688a5fc323%3Fobject%3Dsimple%5Ffile%5Fsd%26uuid%3D83fbc369%2Dee75%2D4880%2Dbd7d%2D809b84983dc8%26expire%5Fdate%3D2022%2D04%2D28T12%3A15%3A36Z%26diskhmac%3DGodKRABB5ONEyPYXs5GELOp1jrY%253D
        //$data=base64_encode($data);

        //$data=curlGet($link,"");        
        //var_dump($data);
        //$data2=file_get_contents($link);
        //var_dump(base64_encode($data2));
        
        //echo "<br>\n---------------------------<br>\n";
        
        $hash=md5("aRRRsd_j".$data."sd__fj_HFGS_slhj");
        $post=[
            "data"=>$data,
            "a"=>1,
            "p"=>$p,            
            "k"=>"HSDFqw__q123we9JJJkh",
            "hash"=>$hash
        ];
        //echo "---------------------------<br>\r\n";
        //print_r($param);
        //echo "---------------------------<br>\r\n";
        $sgn=curlGet2("http://192.168.0.65:11880/sign.php",$post);
        //echo $data;
        //exit;
        if (1==1){
            $param["Документ"]["Этап"]["Вложение"][$resno]=[
                    "Идентификатор"=>$z->Идентификатор, 
                    "Подпись"=>[
                            "Файл"=>[
                                "ДвоичныеДанные"=>$sgn,
                                "Имя"=>$fn.".sgn"
                            ]        
                    ]];
            $resno++;
        }
        
    }
    //print_r($ret);

    //print_r($param);
    $ret=excuteCommand("СБИС.ВыполнитьДействие", $param);
    if (isset($ret->error)){
        echo "#ERR2: ".$ret->error->message;
        exit;
    }        
    //print_r($ret);
    
    $ret=docGet($identifier);

    docUpdateSys($ret->result);
    docUpdateEvent($ret->result,$doc);


}
//-------------------------------
function companyIdetifier($inn,$kpp=""){;
    //$inn="292600685070";
    //$inn="519240214612";
    //$inn="2635247685";
    //$kpp="263501001";

    $param=["Участник"=>[
        "СвЮЛ"=>[
        "ИНН"=>$inn,
        "КПП"=>$kpp
        ]]];
    $ret=excuteCommand("СБИС.ИнформацияОКонтрагенте", $param);
    //print_r($ret);
    //echo json_encode($ret,256);
    //$ret;
    if (isset($ret->error)) {echo "ERR ".$ret->error->code.": ".$ret->error->message; exit;}
    if (!isset($ret->result)) {echo "ERR:"; exit;}    
    
    echo $ret->result->Идентификатор;
}
//-------------------------------
function login(){
global $session;
    if ($session!="") return true;
    $login="nordcom_api";
    $pass="NordC0m@)@@";

    $param=["Параметр"=>[
        "Логин"=>$login,
        "Пароль"=>$pass]];

    $ret=excuteCommand("СБИС.Аутентифицировать", $param, true);
    if ($ret->result) {
        $session=$ret->result;
        return true;
        }
    return false;
}
//-------------------------------
function docCreate($iddoc){
global $zod0x,$zodLocal,$glInn,$glKpp,$deb;

    //docResourceAdd("b2b04cf6-7975-42e3-8165-b8f0a7d1d8ba", "test.txt", "test. Проверка 222222.");
    //docNewStage("b2b04cf6-7975-42e3-8165-b8f0a7d1d8ba","Отправить","Отправка");
    //exit;

    

    $sql="select zodDoc.del, zodDoc.no, zodDoc.data,  zodCompany.inn, zodCompany.kpp,
    (select zodAuthor.firstName from zodAuthor where zodAuthor.inn=zodDoc.zodAuthor limit 1) as firstName,
    (select zodAuthor.lastName from zodAuthor where zodAuthor.inn=zodDoc.zodAuthor limit 1) as lastName,
    (select zodAuthor.patronymic from zodAuthor where zodAuthor.inn=zodDoc.zodAuthor limit 1) as patronymic,
    zodDoc.zodDocType_id
    from zodDoc, zodCompany
    where zodDoc.zod=".intval($zodLocal)." and zodDoc.id=".intval($iddoc)." 
    and zodDoc.zodCompany=zodCompany.id and zodCompany.zod=zodDoc.zod";
    //echo $sql;
    $sql=mysqli_query($zod0x,$sql);
    
    $sqlg=mysqli_fetch_array($sql);
    if (!isset($sqlg['del'])) {echo "ERR: doc not found";exit;}
    if ($sqlg['del']!=0) {echo "ERR: doc is deleted";exit;}

    $typedoc="КоррИсх";
    $type="";
    if ($sqlg['zodDocType_id']==2) {
        $type="upd";
        $typedoc="ДокОтгрИсх";        
    }
    if ($sqlg['zodDocType_id']==1) {
        $type="bill";
        $typedoc="СчетИсх";        
    }
    if ($sqlg['zodDocType_id']==17) {
        $type="cha";
        $typedoc="АктСверИсх";        
    }    

    if ($type==""){
        echo "#ERR: неверный тип документа. ".intval($sqlg['zodDocType_id']);
        exit;
    }


    $url="http://192.168.0.65/zod/edo/ZOD_Exchange/public/".$type."/".intval($iddoc);
    //echo $url."!";
    //exit;
    //echo "<br>";
    //echo "RET: ";
    $ret=curlGetHeader($url,"");
    //print_r($ret);
    $dataResource=$ret['data'];
    $dataResource=mb_convert_encoding($dataResource,'windows-1251','utf-8');

    $headerResource=$ret['header'];
    if (strpos($headerResource,"EDO-Error")!==false){
        $headerResource=substr($headerResource,strpos($headerResource,"EDO-Error"));
        $headerResource=substr($headerResource,0,strpos($headerResource,"Set"));        
        echo "#ERR3: ".$headerResource;
        exit;
    }


    //echo $typedoc;

    //echo $dataResource;


    $nameResource=substr($headerResource,strpos($headerResource,'EDO-File:')+10);
    //echo "!".$nameResource;
    $nameResource=trim(substr($nameResource,0,strpos($nameResource,PHP_EOL)));    
    //echo "!".$nameResource;   

    //echo $headerResource;



    if ($nameResource==""){
        echo "#ERR: пустое имя файла xml";
        exit;        
    }

    if ($nameResource==""){
        echo "#ERR: пустое имя файла xml";
        exit;        
    }    

    if (strpos($nameResource,"rror")!==false){
        echo "#ERR4: ".$nameResource;
        exit;                    
    }


    $inn=$sqlg['inn'];
    $kpp=$sqlg['kpp'];
    
    $firstName=$sqlg['firstName'];
    $lastName=$sqlg['lastName'];
    $patronymic=$sqlg['patronymic'];
    


    $param=[
        "Документ"=>[
           "Дата"=>date("d.m.Y",strtotime($sqlg['data'])),
           "Номер"=>$sqlg['no'],
           //"Идентификатор"=>$iddoc,
           "Контрагент"=>[
              "СвЮЛ"=>[
                 "ИНН"=>$inn,
                 "КПП"=>($kpp==0?"":$kpp),
                 //"Название"=>"Тестовый Получатель"
              ]
            ],
           "НашаОрганизация"=>[
              "СвЮЛ"=>[
                 "ИНН"=>$glInn,
                 "КПП"=>$glKpp
              ]
            ],
           //"Примечание"=>"Здесь обычно указывают примечание",
           //"Редакция": [
              //{
                // "ПримечаниеИС": "РеализацияТоваровУслуг:8bf669c4-042e-4854-b21b-673e8067e83e"
              //}
           //],
           "Автор"=>[
                "Фамилия"=>$firstName,
                "Имя"=>$lastName,
                "Отчество"=>$patronymic,
           ],
           "Ответственный"=>[
                "Фамилия"=>$firstName,
                "Имя"=>$lastName,
                "Отчество"=>$patronymic,
            ],          
           "Тип"=>$typedoc
        ]];
        //print_r($param);
        //echo "-----------------------\r\n";
        //exit;
        $ret=excuteCommand("СБИС.ЗаписатьДокумент", $param);
        //if ($deb!=0) print_r($ret);
        //exit;
        if (isset($ret->error)){
            echo "#ERR5: ".$ret->error->message;
            exit;
        }

        if (!isset($ret->result)) {
            echo "#ERR: СБИС.ЗаписатьДокумент";
            exit;
        }
        if (isset($ret->error)) {
            echo "#ERR6: ".$ret->error->message;
            exit;
        }
        $identifier=$ret->result->Идентификатор;
        //echo "!!!!###!!!";
        //echo "identifier:".$identifier;
        //getResourceArch($ret->result->СсылкаНаАрхив,$identifier.".zip");   
        //echo $dataResource;
        //echo "\n\n\n\n\n\n";  
        docResourceAdd($identifier, $nameResource.".xml", $dataResource);
        //echo "!!!!##!!!!#!!!";        
        $ret=docGet($identifier);
        docUpdateSys($ret->result);
        $sql="select zodEdo.row_id from zodEdo where zodEdo.zod=".intval($zodLocal)." and zodEdo.identifier='".inputclean($identifier)."'";
        //echo $sql;
        $sql=mysqli_query($zod0x,$sql);
        $sqlg=mysqli_fetch_array($sql);
        if (!isset($sqlg['row_id'])) {echo "#ERR: Документ не добавлен в БД. identifier:".$identifier; exit;}
        $doc=$sqlg['row_id'];
        $sql="update zodEdo set zodDoc=".intval($iddoc)." where row_id=".intval($doc);
        $sql=mysqli_query($zod0x,$sql);        
        docUpdateEvent($ret->result,$doc);
        //echo $doc;
        docConfirm($doc,$identifier,$_GET['sert'],$_GET['p']);
        echo "#OK#".$doc;        
        //docList("Отправленные");
}
//-------------------------------
function docResourceAdd($identifier, $name, $data){
    
    $param=[
        "Документ"=>[
            "Идентификатор"=>$identifier,
            "Вложение"=>[
                  "Файл"=>[
                     "Имя"=>$name,
                     "ДвоичныеДанные"=>base64_encode($data)
                  ]
            ]        
        ]
    ];

    $ret=excuteCommand("СБИС.ЗаписатьВложение", $param);
    //print_r($ret);
    $ret=docGet($identifier);
    //print_r($ret);    
    docUpdateSys($ret->result);

}
//-------------------------------
function docGet($identifier){
global $zod0x,$glInn,$glKpp,$zodLocal;
    $param=[
    "Документ"=>[
        "Идентификатор"=>$identifier,
        //"ДопПоля": "ДополнительныеПоля"
        ]
    ];

    $ret=excuteCommand("СБИС.ПрочитатьДокумент", $param);
    //print_r($ret);
    //exit;
    return $ret;
}
//-------------------------------
function docUpdateSys($doc){
global $zod0x,$glInn,$glKpp,$zodLocal;


    $inout=0;
    if ($doc->Направление!="Входящий") $inout=1;
    $del=0;
    if ($doc->Удален!="Нет") $del=1;
    $identifier=$doc->Идентификатор;
    $sum=$doc->Сумма;
    $link=$doc->СсылкаДляКонтрагент;
    $datacreate=$doc->ДатаВремяСоздания;
    $inn=isset($doc->Контрагент->СвЮЛ)?$doc->Контрагент->СвЮЛ->ИНН:$doc->Контрагент->СвФЛ->ИНН;
    $kpp=isset($doc->Контрагент->СвЮЛ)?$doc->Контрагент->СвЮЛ->КПП:"";;
    $name=$doc->Название;
    $type=$doc->Тип;

    $sql="select row_id from zodEdoType where name='".$type."'";
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);

    if (isset($sqlg['row_id'])) {
        $type_id=$sqlg['row_id'];
    }
    else {
        $sql="insert into zodEdoType set name='".$type."'";
        $sql=mysqli_query($zod0x,$sql);
        $type_id=mysqli_insert_id($zod0x);
    }

    //echo "".$identifier.": ".$doc->Контрагент->СвЮЛ->Название." (ИНН:".$inn." КПП:".$kpp."). ".$name;

    $sql="select row_id from zodEdo where zod=".intval($zodLocal)." and identifier='".$identifier."'";
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);
    if (isset($sqlg['row_id'])) {
        $edo_id=$sqlg['row_id'];
    }    
    else {        
        $sql="insert into zodEdo set zod=".intval($zodLocal).",del=".intval($del).",`inout`=".intval($inout).",dataCreate='".toDate($datacreate)."',data=now(),identifier='".inputclean($identifier)."',name='".inputclean($name)."',zodCompany='".$inn."',zodCompanyKpp='".$kpp."',sum=".floatval($sum).",zodEdoType_id=".intval($type_id).",link='".inputclean($link)."'";
        $sql=mysqli_query($zod0x,$sql);
        $edo_id=mysqli_insert_id($zod0x);
    }
    //echo "<br>";

    $res=array();
    $modify=false;
    foreach ($doc->Вложение as $z2){    
        $r_del=0;
        if ($z2->Удален!="Нет") $r_del=1;
        $r_identifier=$z2->Идентификатор;
        $res[]=inputclean($r_identifier);
        $r_data=$z2->Дата;
        $r_no=$z2->Номер;
        $r_name=$z2->Название;
        $r_sum=$z2->Сумма;
        $r_link=$z2->СсылкаНаHTML;
        $r_linkCab=$z2->СсылкаВКабинет;
        $r_file=$z2->Файл->Ссылка;
        $r_fileName=$z2->Файл->Имя;
        $r_type=$z2->Тип;    

        $r_sys=0;
        if ($z2->Служебный=="Да") $r_sys=1;

        $sql="select row_id from zodEdoType where name='".$r_type."'";
        $sql=mysqli_query($zod0x,$sql);
        $sqlg=mysqli_fetch_array($sql);

        if (isset($sqlg['row_id'])) {
            $r_type_id=$sqlg['row_id'];
        }
        else {
            $sql="insert into zodEdoType set name='".$r_type."'";
            $sql=mysqli_query($zod0x,$sql);
            $r_type_id=mysqli_insert_id($zod0x);
        }           
        //echo "&nbsp;&nbsp;- ".$r_identifier.":".$r_name; 

        $sql="select identifier from zodEdoResource where zod=".intval($zodLocal)." and zodEdo_id=".intval($edo_id)." and identifier='".inputclean($r_identifier)."'";
        $sql=mysqli_query($zod0x,$sql);
        $sqlg=mysqli_fetch_array($sql);
        if (isset($sqlg['identifier'])) {
            $r_edo_id=$sqlg['identifier'];
            $sql="update zodEdoResource set del=0 where zod=".intval($zodLocal)." and zodEdo_id=".intval($edo_id)." and identifier='".inputclean($r_identifier)."'";                
            //echo "<br><br>".$sql."<br><br>";
            $sql=mysqli_query($zod0x,$sql);            
        }    
        else {        
            $sql="insert into zodEdoResource set zod=".intval($zodLocal).", zodEdo_id=".intval($edo_id).", del=".intval($r_del)."
            ,identifier='".inputclean($r_identifier)."', data='".toDate($r_data)."',no='".inputclean($r_no)."',name='".inputclean($r_name)."',sum=".floatval($r_sum).",link='".inputclean($r_link)."'
            ,isSystem=".intval($r_sys).", linkCab='".inputclean($r_linkCab)."'
            ,file='".inputclean($r_file)."',fileName='".inputclean($r_fileName)."',zodEdoType_id=".intval($r_type_id);                
            //echo "<br><br>".$sql."<br><br>";
            $sql=mysqli_query($zod0x,$sql);
            //$r_edo_id=mysqli_insert_id($zod0x);
            $modify=true;
        }              

        if (isset($z2->Подпись)){
            foreach ($z2->Подпись as $sign){ 
                $s_inout=0;
                if ($sign->Направление!="Входящая") $s_inout=1;            
                $s_isSkilled=0;
                if ($sign->Сертификат->Квалифицированный=="Да") $s_isSkilled=1;
                $s_dataStart=$sign->Сертификат->ДействителенС;
                $s_dataEnd=$sign->Сертификат->ДействителенПо;
                $s_thumbprint=$sign->Сертификат->Отпечаток;

                $s_author=$sign->Сертификат->ФИО;
                $s_post=$sign->Сертификат->Должность;
                $s_inn=$sign->Сертификат->ИНН;
                $s_name=$sign->Сертификат->Название;
                $s_serial=$sign->Сертификат->СерийныйНомер;
                $s_publisher=$sign->Сертификат->Издатель;
                $s_link="";
                $s_fileName="";
                if (isset($sign->Сертификат->Файл)){
                    $s_link=$sign->Сертификат->Файл->Ссылка;
                    $s_fileName=$sign->Сертификат->Файл->Имя;
                }
            
                $s_publisher_id=0;            
                $sql="select row_id from zodEdoResourceSignedPublisher where name='".inputclean($s_publisher)."'";
                $sql=mysqli_query($zod0x,$sql);
                $sqlg=mysqli_fetch_array($sql);
                if (isset($sqlg['row_id'])){
                    $s_publisher_id=intval($sqlg['row_id']);
                }
                else {
                    $sql="insert into zodEdoResourceSignedPublisher set del=0, name='".inputclean($s_publisher)."'";
                    $sql=mysqli_query($zod0x,$sql);                
                    $s_publisher_id=mysqli_insert_id($zod0x);
                }


                $sql="select identifier from zodEdoResourceSigned 
                where zod=".intval($zodLocal)." and zodEdo_id=".intval($edo_id)." and identifier='".inputclean($r_identifier)."' 
                and `inout`=".intval($s_inout)." and isSkilled=".intval($s_isSkilled)." and thumbprint='".inputclean($s_thumbprint)."'";

                //echo "<br><br>".$sql."<br><br>";
                $sql=mysqli_query($zod0x,$sql);
                $sqlg=mysqli_fetch_array($sql);
                if (isset($sqlg['identifier'])){
                    $sql="update zodEdoResourceSigned set del=0
                    where zod=".intval($zodLocal)." and zodEdo_id=".intval($edo_id)." and identifier='".inputclean($r_identifier)."' 
                    and `inout`=".intval($s_inout)." and isSkilled=".intval($s_isSkilled)." and thumbprint='".inputclean($s_thumbprint)."'";
                    $sql=mysqli_query($zod0x,$sql);                
                }
                else {
                    $sql="insert into zodEdoResourceSigned set del=0,
                    zod=".intval($zodLocal).", zodEdo_id=".intval($edo_id).", identifier='".inputclean($r_identifier)."',
                    `inout`=".intval($s_inout).", isSkilled=".intval($s_isSkilled).", thumbprint='".inputclean($s_thumbprint)."',
                    dataStart='".toDate($s_dataStart)."', dataEnd='".toDate($s_dataEnd)."', author='".inputclean($s_author)."', post='".inputclean($s_post)."',
                    inn='".$s_inn."', name='".inputclean($s_name)."', serial='".inputclean($s_serial)."', zodEdoResourceSignedPublisher_id='".inputclean($s_publisher_id)."', link='".inputclean($s_link)."',
                    fileName='".inputclean($s_fileName)."'
                    ";
                    $sql=mysqli_query($zod0x,$sql);                                
                }


            }
        }
        //echo "<br>";                        
    }


    $sql="update zodEdoResource set del=1 where zod=".intval($zodLocal)." and zodEdo_id=".intval($edo_id)." and identifier not in ('".implode("','",$res)."')";
    //echo "<br><br>".$sql."<br><br>";
    $sql=mysqli_query($zod0x,$sql);  

    //-----Архив------
    //print_r($res);
    //echo $identifier;
    //$modify=getResourceModify($identifier, $res);
    //echo "modify:".$modify;
    //exit;
    $arch=$doc->СсылкаНаАрхив;
    getResourceArch($arch,$identifier,$modify);
    //exit;
    //echo "<br>";
}
//-------------------------------
function getResourceModify($identifier, $res){
    $dir=dirname(__FILE__) . '/archive/';
    foreach ($res as $r){
        //echo $dir;
        $folder=substr($r,0,strpos($r,"-"));
        if (is_dir($dir."".$folder)===false) {
            return true;
        }
        if (!file_exists($dir.$folder."/".$r.".zip")) return true;
    }
    return false;
}
//-------------------------------
function docNewStage($identifier,$stageName,$stageName2){
    global $zod0x,$glInn,$glKpp,$zodLocal;

    $param=[
    "Документ"=>[
        "Идентификатор"=>$identifier,
        "Этап"=>[
            "Действие"=>[
                "Название"=>$stageName
            ],
            "Название"=>$stageName2
        ]
        //"ДопПоля": "ДополнительныеПоля"
        ]
    ];
    print_r($param);
    $ret=excuteCommand("СБИС.ВыполнитьДействие", $param);
    print_r($ret);    
    $ret=docGet($identifier); 
    print_r($ret);   
    docUpdateSys($ret->result);
}
//-------------------------------
function docUpdate($doc){
global $zod0x, $zodLocal;
    $sql="select zodEdo.identifier from zodEdo where zodEdo.zod=".intval($zodLocal)." and zodEdo.row_id=".intval($doc);
    //echo $sql;
    $sql=mysqli_query($zod0x,$sql);
    $sqlg=mysqli_fetch_array($sql);
    if (!isset($sqlg['identifier'])) {echo "#ERR: Неверный id документа. ID:".$doc; exit;}
    $identifier=$sqlg['identifier'];
    $ret=docGet($identifier);
    //print_r($ret);
    docUpdateSys($ret->result);
    docUpdateEvent($ret->result,$doc);
}
//-------------------------------
function docListSert($p){
    $data="";
    $hash=md5("aRRRsd_j".$data."sd__fj_HFGS_slhj");
    $post=[
        "data"=>$data,
        "a"=>2,
        "p"=>$p,
        "k"=>"HSDFqw__q123we9JJJkh",
        "hash"=>$hash
    ];
    //echo "---------------------------<br>\r\n";
    //print_r($post);
    //echo "---------------------------<br>\r\n";
    $ret=curlGet2("http://192.168.0.65:11880/sign.php",$post);
    $ret=json_decode($ret);
    foreach($ret as $k=>$z){
        if ($k==0) continue;
        foreach($z as $z2){
            echo $z2."#|#";
        }
        echo "\r\n";
    }
    
}
//-------------------------------
?>