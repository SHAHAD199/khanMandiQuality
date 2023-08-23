<?php

namespace App\Exports;

use App\Models\Forem;
use Maatwebsite\Excel\Concerns\FromCollection;

class FormExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Forem::all();
    }
}
