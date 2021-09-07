<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Exporter;

class ClientsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*public function model(array $row)
    {
        dd($row);
        return new Client([
            //
        ]);
    }*/

    public function collection(Collection $rows)
    {
        $filter = $rows
            ->reject(function ($item){
                foreach ($item as $k => $v){
                    if($v == ''){
                        return true;
                    }
                }
            });
        $filter->shift(1);
        $news = $filter->toArray();
        for ($i=0; $i<= count($news) -1;$i++){
            $client = new Client();
            $client->cod = $news[$i][0];
            $client->name = $news[$i][1];
            $city = City::where('name', $news[$i][2])->first();
            if(!is_null($city)){
                $client->cities_id = $city->id;
            }
            $client->save();
        }
    }
}
