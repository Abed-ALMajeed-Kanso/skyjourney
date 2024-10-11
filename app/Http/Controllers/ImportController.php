<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class ImportController extends Controller
{
    public function import()
    {
        // Specify the path to the CSV file 
        $filePath = storage_path('app/uploads/users.csv');

        // Load the data from the CSV file
        $data = Excel::toArray(new UsersImport, $filePath);

        // Assuming your data is in the first sheet
        return response()->json($data[0]);
    }
}
