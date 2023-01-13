<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ZipArchive;
use XBase\TableReader;
use App\zodcityhouse;
use App\zodFiasTypes;
use \App\zodCityStreet;
use Illuminate\Support\Facades\DB;



class fileController extends Controller
{

    public function update(Request $request)
    {

        if ($request->isMethod('post')) {

            $zip = new ZipArchive();
            /*
        $file_path = storage_path('app/public/base.zip');
      
  $res = $zip->open($file_path); if ($res === TRUE) { $zip->extractTo(  storage_path("app/fias/")); $zip->close(); echo 'woot!'; } else { echo 'doh!'; }
*/
            ini_set('max_execution_time', 120);
            $files = Storage::disk('fias')->files();
            foreach ($files as $file) {
                if (strpos($file, "DDROB") == 1) {
                    $mathces = [];
                    preg_match('/(?<=ADDROB)(\d*)(?=.DBF)/si', $file, $mathces);
                    $region = $mathces[0];

                    $table = new TableReader(storage_path(
                        'app/fias/' . $file

                    ));

                    $conv = "utf-8";
                    $from = 'cp866';
                    $limit = 10;
                    $limitctr = 0;
                    while (($record = $table->nextRecord()) && ($limitctr <= $limit)) {

                        $limitctr++;
                        echo $record->AOGUID;
                        echo "<br>";
                        echo mb_convert_encoding($record->SHORTNAME, $conv, $from);
                        echo "<br>";
                        echo mb_convert_encoding($record->OFFNAME, $conv, $from);
                        echo "<br>";
                    }
                }
            }
        }
    }

    public function updateindex(Request $request)
    {

        if ($request->isMethod('get')) {

            $zip = new ZipArchive();
            /*
        $file_path = storage_path('app/public/base.zip');
      
  $res = $zip->open($file_path); if ($res === TRUE) { $zip->extractTo(  storage_path("app/fias/")); $zip->close(); echo 'woot!'; } else { echo 'doh!'; }
*/
            ini_set('max_execution_time', 0);
            $files = Storage::disk('fias')->files();

            $regctr = 0;
            foreach ($files as $file) {


                if (strpos($file, "OUSE") == 1) {
                    $mathces = [];
                    preg_match('/(?<=HOUSE)(\d*)(?=.DBF)/si', $file, $mathces);
                    $region = $mathces[0];
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

                        $limitctr++;/*
                        echo trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from));
                        echo "<br>";
                        echo $record->AOGUID;
                        echo "<br>";
                        echo $record->HOUSEGUID;

                        echo "<br> STRUCNUM";
                        echo mb_convert_encoding($record->STRUCNUM, $conv, $from);
                        echo "<br> BUILDNUM";
                        echo mb_convert_encoding($record->BUILDNUM, $conv, $from);
                        echo "<br> HOUSENUM";
                        echo mb_convert_encoding($record->HOUSENUM, $conv, $from);
                        echo "<br>";
*/

                        $street_id = \App\zodCityStreet::where('fias', $record->AOGUID)->first();
                        Storage::disk('manage')->put('pending.txt', $file . '/' . $region . "/86/" . $regctr . "/" . $limitctr . "/" . $records . "/" . $street_id . "/" . $record->AOGUID);




                        if ($street_id) {
                            $street_id = $street_id->row_id != "" ? $street_id->row_id : 0;
                        } else {
                            $street_id = 0;
                        }

                        $flight = new zodcityhouse;

                        $flight->postalcode =  trim(mb_convert_encoding($record->POSTALCODE, $conv, $from)) == "" ? 0 : trim(mb_convert_encoding($record->POSTALCODE, $conv, $from));
                        $flight->aoguid = DB::connection()->getPdo()->quote(trim(mb_convert_encoding($record->AOGUID, $conv, $from)));
                        $flight->streetid = trim(mb_convert_encoding($street_id, $conv, $from));
                        $flight->buildnum = DB::connection()->getPdo()->quote(trim(mb_convert_encoding($record->BUILDNUM, $conv, $from)));
                        $flight->housenum = DB::connection()->getPdo()->quote(trim(mb_convert_encoding(($record->HOUSENUM), $conv, $from)));

                        $flight->save();
                    }
                    //echo $limitctr;
                }
            }
            Storage::disk('manage')->delete('pending.txt');
        }
    }


    function upadteFiasTypes()
    {

        $table = new TableReader(storage_path(
            'app/fias/SOCRBASE.DBF'

        ));

        $conv = "utf-8";
        $from = 'cp866';

        while ($record = $table->nextRecord()) {
            echo "Try...";
            $fiastypes = new zodFiasTypes;

            $fiastypes->code = trim(mb_convert_encoding($record->KOD_T_ST, $conv, $from));
            $fiastypes->name = trim(mb_convert_encoding($record->SCNAME, $conv, $from));
            $fiastypes->fullname = trim(mb_convert_encoding($record->SOCRNAME, $conv, $from));
            $fiastypes->level = trim(mb_convert_encoding($record->LEVEL, $conv, $from));

            $fiastypes->save();
        }
        echo "Done!";
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

    function uploadDBF()
    {
    }
}

/*
<?php
    $tbl = "cc";
    $db_uname = 'root';
    $db_passwd = '';
    $db = 'aa';
    $conn = mysql_pconnect('localhost',$db_uname, $db_passwd);

    // Path to dbase file
    $db_path = "dbffile/bbsres12.dbf";

    // Open dbase file
    $dbh = dbase_open($db_path, 0) or die("Error! Could not open dbase database file '$db_path'.");

    // Get column information
    $column_info = dbase_get_header_info($dbh);

    // Display information
    // print_r($column_info);

    $line = array();

    foreach($column_info as $col) {
        switch($col['type']) {
            case 'character':
                $line[]= "`$col[name]` VARCHAR( $col[length] )";
                break;
            case 'number':
                $line[]= "`$col[name]` FLOAT";
                break;
            case 'boolean':
                $line[]= "`$col[name]` BOOL";
                break;
            case 'date':
                $line[]= "`$col[name]` DATE";
                break;
            case 'memo':
                $line[]= "`$col[name]` TEXT";
                break;
        }
    }

    $str = implode(",",$line);
    $sql = "CREATE TABLE `$tbl` ( $str );";

    mysql_select_db($db, $conn);

    mysql_query($sql, $conn);
    set_time_limit(0); // I added unlimited time limit here, because the records I imported were in the hundreds of thousands.

    // This is part 2 of the code

    import_dbf($db, $tbl, $db_path);

    function import_dbf($db, $table, $dbf_file) {
        global $conn;

        if (!$dbf = dbase_open ($dbf_file, 0)) {
            die("Could not open $dbf_file for import.");
        }

        $num_rec = dbase_numrecords($dbf);
        $num_fields = dbase_numfields($dbf);
        $fields = array();

        for ($i=1; $i<=$num_rec; $i++) {
            $row = @dbase_get_record_with_names($dbf,$i);
            $q = "insert into $db.$table values (";

            foreach ($row as $key => $val) {
                if ($key == 'deleted') {
                    continue;
                }
                $q .= "'" . addslashes(trim($val)) . "',"; // Code modified to trim out whitespaces
            }

            if (isset($extra_col_val)) {
                $q .= "'$extra_col_val',";
            }

            $q = substr($q, 0, -1);
            $q .= ')';

            //if the query failed - go ahead and print a bunch of debug info
            if (!$result = mysql_query($q, $conn)) {
                print (mysql_error() . " SQL: $q\n");
                print (substr_count($q, ',') + 1) . " Fields total.";
                $problem_q = explode(',', $q);
                $q1 = "desc $db.$table";
                $result1 = mysql_query($q1, $conn);
                $columns = array();
                $i = 1;
                
                while ($row1 = mysql_fetch_assoc($result1)) {
                    $columns[$i] = $row1['Field'];
                    $i++;
                }

                $i = 1;

                foreach ($problem_q as $pq) {
                    print "$i column: {$columns[$i]} data: $pq\n";
                    $i++;
                }

                die();
            }
        }
    }

?>*/