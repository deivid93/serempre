<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return DB::table('client as cl')
                    ->join('cities as ci', 'cl.cities_id', '=', 'ci.id')
                    ->select('cl.cod', 'cl.name', 'ci.name as ciudad')
                    ->get();
    }


}
