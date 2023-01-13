<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use XBase\TableReader;
use App\zodСityDistrict;
use App\zodСityFias;
use Exception;
use App\zodFiasTypes;
use Illuminate\Support\Facades\DB;

class fixController extends Controller
{
    public function fixdistrict(Request $request)
    {

        if ($request->isMethod('get')) {



            ini_set('max_execution_time', 0);
            $files = Storage::disk('fias')->files();

            $regctr = 0;
            foreach ($files as $file) {


                if (strpos($file, "DDROB10") == 1) {
                    $mathces = [];
                    preg_match('/(?<=DDROB)(\d*)(?=.DBF)/si', $file, $mathces);
                    $region = $mathces[0];
                    $regctr++;
                    $table = new TableReader(storage_path(
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
                        Storage::disk('manage')->put('pending.txt', "...");



                        $fias = trim(mb_convert_encoding(($record->AOGUID), $conv, $from));
                        $parentfias = trim(mb_convert_encoding(($record->PARENTGUID), $conv, $from));

                        $DistrictFias_MySQL = \App\zodCityDistrict::where('fias', $fias)->first();
                        $CityFias_MySQL = "";


                        if ($DistrictFias_MySQL) {
                            echo   $DistrictFias_MySQL->id;
                            echo "Найден ФИАС региона. " . $DistrictFias_MySQL->fias . "</br>";
                            echo   "ID: " . $DistrictFias_MySQL->id . "</br>";
                            $CityFias_MySQL = \App\zodCityFias::where('fias', $parentfias)->first();
                            if ($CityFias_MySQL) {
                                echo "Найден id города в MYSQL. $CityFias_MySQL->city_id </br>";
                                $DistrictFias_MySQL->city_id = $CityFias_MySQL->city_id;
                                try {
                                    $DistrictFias_MySQL->save();
                                } catch (Exception $e) {
                                    echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
                                }
                            }
                        }
                    }
                    //echo $limitctr;
                }
            }
            Storage::disk('manage')->delete('pending.txt');
        }
    }


    function fixTypes()
    {

        ini_set('max_execution_time', 0);

        $files = Storage::disk('fias')->files();

        $regctr = 0;



        echo "Поиск источника!!";
        foreach ($files as $file) {
            echo "Поиск источника!!";
            try {
                if (strpos($file, "DDROB") == 1) {
                    echo "источник Найден!!";
                    echo $file . "<br>";
                    $mathces = [];
                    preg_match('/(?<=DDROB)(\d*)(?=.DBF)/si', $file, $mathces);
                    $region = $mathces[0];
                    $regctr++;
                    $table = new TableReader(storage_path(
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


                        $fias = trim(mb_convert_encoding(($record->AOGUID), $conv, $from));

                        $streettype = trim(mb_convert_encoding(($record->SHORTNAME), $conv, $from));

                        $streetlevel = trim(mb_convert_encoding(($record->AOLEVEL), $conv, $from));




                        $code = \App\zodFiasTypes::where('name', $streettype)->where('level', $streetlevel)->first();




                        $CityFias_MySQL = \App\zodCityFias::where('fias', $fias)->first();
                        if ($CityFias_MySQL && $code) {
                            if (in_array($code->level, [35, 4, 6])) {

                                echo "</br></br></br>fias: ";
                                echo   $fias;
                                echo "</br>streettype: ";
                                echo $streettype;
                                echo "</br>level: ";
                                echo $streetlevel;




                                echo "</br>codesql: ";
                                echo "$code->code";
                                echo "</br>add: true</br>";

                                print_r($code->level);
                                echo "</br>street: </br>";
                                echo "</br>CityFias_MySQL->city_id: $CityFias_MySQL->city_id";
                                echo \App\zodCity::where('row_id', $CityFias_MySQL->city_id)->first()->city;

                                $City_MySQL = \App\zodCity::where('row_id', $CityFias_MySQL->city_id)->update(['citytype_id' => $code->code]);

                                echo "</br></br>_____</br>";
                            }
                        }


                        if ($code) {
                            if (in_array($code->level, [7])) {
                                echo "Улица";
                                echo "тип: " . $streettype;
                                $StreetFias_MySQL = \App\zodCityStreet::where('fias', $fias)->update(['citystreettype_id' => $code->code]);
                            }
                        }
                    }
                    echo "done!";
                }
            } catch (\Throwable $e) { // For PHP 7

                echo "Упс!Косячок";
            } catch (\Exception $e) { // For PHP 5

                echo "Упс!Косячок";
            }
        }
    }


    function getTypes()
    {
        $table = new TableReader(storage_path(
            'app/fias/SOCRBASE.DBF'

        ));
        $types = [];
        while ($record = $table->nextRecord()) {
            $types[$record->KOD_T_ST] = $record->SC_NAME;
        }
        return $types;
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
