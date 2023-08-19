<?php 

namespace App\Services\EmployeesReports;

use App\Imports\MissedCallsImport;
use Maatwebsite\Excel\Facades\Excel;

class PostEmployeeReportService 
{
   public static function store($request)
   {
          Excel::import(new MissedCallsImport() , $request->file);
          return redirect(url('employees'));
   }
}