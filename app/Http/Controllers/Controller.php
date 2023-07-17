<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Support\Facades\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    
    public function retriveRecords() {
        $records = [];
        $csvFile = fopen("test.csv", "r");
        while ( !feof($csvFile) ) {
            array_push($records, fgetcsv($csvFile, 1000, ","));
        }
        fclose($csvFile);
        return view('list-records', ['records' => $records]);
    }

    public function addRecord()
    {        
        $newRecords = [[Request::input('ref'), Request::input('forename'), Request::input('surname'), Request::input('email'), Request::input('phone')]];
        $csvFile = fopen("test.csv", "a");
        
        // For the sake of speed in completing these tests I am adding a new line before each item
        // However in a production environment I would be checking if a new line is needed and
        // handling it appropriately.
        fwrite($csvFile, "\r\n");

        foreach($newRecords as $newrecord) {
            fputcsv($csvFile, $newrecord, ',', "\"", "\\", '');
        }
        fclose($csvFile);

        return 200;
    }

}
