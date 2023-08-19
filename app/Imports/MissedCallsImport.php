<?php

namespace App\Imports;

use App\Models\MissedCall;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class MissedCallsImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        MissedCall::create([
           'source'            => $row[1],
           'datetime'          => Carbon::parse($row[0])->format('Y-m-d H:i'),
           'destination'       => $row[2],
           'number_of_attmpts' => $row[3],
           'status'            => $row[4]
        ]);
    }
}
