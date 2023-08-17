<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ExcelController extends Controller
{
    public function create()
    {
       return view('excel.add');
    }

    public function store(Request $request)
    {
          FacadesExcel::import(new OrderImport() , $request->file);
          return redirect(url('orders'));
    }
}
