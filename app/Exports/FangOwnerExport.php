<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class FangOwnerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\FangOwner::all();
    }
}
