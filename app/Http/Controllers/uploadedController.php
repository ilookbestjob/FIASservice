<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ZipArchive;
use XBase\TableReader;
use App\zodcityhouse;
use App\zodcityStreet;
use App\zodcityArea;
use Illuminate\Support\Facades\DB;

class uploadedController extends Controller
{
    public function start(Request $request)
    {

        if ($request->isMethod('post')) {

            $zip = new ZipArchive();
            /*
        $file_path = storage_path('app/public/base.zip');
      
  $res = $zip->open($file_path); if ($res === TRUE) { $zip->extractTo(  storage_path("app/fias/")); $zip->close(); echo 'woot!'; } else { echo 'doh!'; }
*/
            ini_set('max_execution_time', 0);
            $files = Storage::disk('fias')->files();
            $regions = json_decode($request->getContent(), true)["selected"];
            $types = json_decode($request->getContent(), true)["uploadtypes"];


            $regctr = 0;
            foreach ($files as $file) {



                if (in_array(1, $types)) {
                    if (strpos($file, "OUSE") == 1) {
                        $mathces = [];
                        preg_match('/(?<=HOUSE)(\d*)(?=.DBF)/si', $file, $mathces);
                        $region = $mathces[0];

                        if (in_array($region, $regions)) {
                            $regctr++;
                            $table = new TableReader(storage_path(
                                'app/fias/' . $file

                            ));
                            echo $records = $this->dbase_numrecords(storage_path(
                                'app/fias/' . $file

                            ));
                            $conv = "utf-8";
                            $from = 'cp866';
                            $limit = 10;
                            $limitctr = 0;
                            while ($record = $table->nextRecord()) {
                                if (Storage::disk('manage')->exists('stop.txt')) {
                                    Storage::disk('manage')->delete('stop.txt');
                                    Storage::disk('manage')->delete('pending.txt');
                                    exit;
                                }

                                $limitctr++;

                                try {


                                    $street_id = \App\zodCityStreet::where('fias', $record->AOGUID)->first();
                                    Storage::disk('manage')->put('pending.txt', $file . '/' . $region . "/86/" . $regctr . "/" . $limitctr . "/" . $records . "/" . $street_id . "/" . $record->AOGUID);




                                    if ($street_id) {
                                        $street_id = $street_id->row_id != "" ? $street_id->row_id : 0;
                                    } else {
                                        $street_id = 0;
                                    }

                                    $house = new zodcityhouse;

                                    $house->postalcode =  trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from));
                                    $house->streetid = trim(mb_convert_encoding($street_id, $conv, $from));
                                    $house->buildnum = DB::connection()->getPdo()->quote(trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)));
                                    $house->housenum = DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from)));

                                    $house->save();

                                    // call a success/error/progress handler
                                } catch (\Throwable $e) { // For PHP 7

                                    Storage::disk('manage')->append('error.log', "Ошибка SQL:" . trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) . "|" . trim(mb_convert_encoding($record->AOGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->HOUSEGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)) . "|" . DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from))));
                                } catch (\Exception $e) { // For PHP 5

                                    Storage::disk('manage')->append('error.log', "Ошибка SQL:" . trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) . "|" . trim(mb_convert_encoding($record->AOGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->HOUSEGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)) . "|" . DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from))));
                                }
                            }
                            //echo $limitctr;

                        } else {
                            echo "Регион " . $region . " не в списке регионов";
                        }
                    }
                }

                if (in_array(2, $types)) {
                    if (strpos($file, "DDROB") == 1) {

                        $mathces = [];
                        preg_match('/(?<=ADDROB)(\d*)(?=.DBF)/si', $file, $mathces);
                        $region = $mathces[0];

                        if (in_array($region, $regions)) {
                            $regctr++;
                            $table = new TableReader(storage_path(
                                'app/fias/' . $file

                            ));
                            echo $records = $this->dbase_numrecords(storage_path(
                                'app/fias/' . $file

                            ));
                            $conv = "utf-8";
                            $from = 'cp866';
                            $limit = 10;
                            $limitctr = 0;
                            while ($record = $table->nextRecord()) {
                                if (Storage::disk('manage')->exists('stop.txt')) {
                                    Storage::disk('manage')->delete('stop.txt');
                                    Storage::disk('manage')->delete('pending.txt');
                                    exit;
                                }

                                $limitctr++;

                                try {


                                    //Storage::disk('manage')->put('pending.txt', $file . '/' . $region . "/86/" . $regctr . "/" . $limitctr . "/" . $records . "/" . $street_id . "/" . $record->AOGUID);



                                    if ($record->AOLEVEL * 1 == 3) {

                                        $area = new zodCityArea;

                                        $area->name =  trim(mb_convert_encoding($record->OFFNAME, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->OFFNAME, $conv, $from));


                                        $area->region_code = $region;
                                        $area->fias = trim(mb_convert_encoding($record->AOGUID, $conv, $from));



                                        $area->save();
                                    }
                                } catch (\Throwable $e) { // For PHP 7
                                    print_r($area);
                                    echo trim(mb_convert_encoding($record->OFFNAME, $conv, $from));
                                    echo ": err</br>";
                                    //  Storage::disk('manage')->append('error.log', "Ошибка SQL:" . trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) . "|" . trim(mb_convert_encoding($record->AOGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->HOUSEGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)) . "|" . DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from))));
                                } catch (\Exception $e) { // For PHP 5
                                    print_r($area);
                                    echo trim(mb_convert_encoding($record->OFFNAME, $conv, $from));
                                    echo ": err</br>";
                                    //   Storage::disk('manage')->append('error.log', "Ошибка SQL:" . trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) . "|" . trim(mb_convert_encoding($record->AOGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->HOUSEGUID, $conv, $from)) . "|" . trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)) . "|" . DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from))));
                                }
                            }
                        }
                    }
                }

                if (in_array(3, $types)) {
                    if (strpos($file, "DDROB") == 1) {

                        $mathces = [];
                        preg_match('/(?<=ADDROB)(\d*)(?=.DBF)/si', $file, $mathces);
                        $region = $mathces[0];

                        if (in_array($region, $regions)) {
                            $regctr++;
                            $table = new TableReader(storage_path(
                                'app/fias/' . $file

                            ));
                            echo $records = $this->dbase_numrecords(storage_path(
                                'app/fias/' . $file

                            ));
                            $conv = "utf-8";
                            $from = 'cp866';
                            $limit = 10;
                            $limitctr = 0;
                            while ($record = $table->nextRecord()) {
                                if (Storage::disk('manage')->exists('stop.txt')) {
                                    Storage::disk('manage')->delete('stop.txt');
                                    Storage::disk('manage')->delete('pending.txt');
                                    exit;
                                }

                                $limitctr++;
                                // if ($limitctr > 200000) exit;
                                try {


                                    if (in_array($record->AOLEVEL * 1, [4, 6])) {

                                        $areas = \App\zodCityArea::where('fias', $record->PARENTGUID)->get();
                                        $city = \App\zodCityFias::where('fias', $record->AOGUID)->first();
                                      

                                        foreach ($areas as $area) {
                                            \App\zodCity::where('row_id',$city->city_id)->update(['cityarea_id' => $area->id]);

                                            echo  trim(mb_convert_encoding($record->OFFNAME, $conv, $from));
                                            echo "=";
                                            echo $city->city_id ? $city->city_id : "";
                                            echo ": ";

                                            echo $area->name;
                                            echo "</br>PARENT GUID: ";
                                            echo $record->PARENTGUID;
                                            echo "</br>GUID: ";
                                            echo $record->AOGUID;
                                            echo "</br>______________________</br>";
                                        }
                                    }


                                    Storage::disk('manage')->put('pending.txt', $file . '/' . $region . "/86/" . $regctr . "/" . $limitctr . "/" . $records . "/" . "street_id" . "/" . $record->AOGUID);

                                } catch (\Throwable $e) { // For PHP 7

                                    echo "Упс!Косячок";
                                } catch (\Exception $e) { // For PHP 5

                                    echo "Упс!Косячок";
                                }
                            }
                        }
                    }
                }
                Storage::disk('manage')->delete('pending.txt');
            }
        }
    }
    public function checkCity($fias, $city)
    {
    }
    function dbase_numrecords($dbfname)
    {
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        echo $dbfname . "</br>";
        print $header['RecordCount'];
        echo "</br>____________</br>";
        fclose($fdbf);
    }
}
