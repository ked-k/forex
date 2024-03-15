<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\inventory\item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


// class ProductsImport implements ToCollection
// {
//     /**
//     * @param Collection $collection
//     */
//     public function collection(Collection $collection)
//     {
//         //
//     }

// }
class ProductsImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $date = date('Y-m-d');
        return new item([
            'item_name' => $row[0],
            'unit_id' => $row[1],
            'subunit_id' => $row[2],
            'cost_price'=> $row[3],
            'uom_id'=> $row[4],
            'supplier_id'=> $row[5],
            'color'=> $row[6],
            'sale_price'=> $row[7],
            'date_added' => date('Y-m-d'),
            'syscode' => random_int(1000, 9999).time(),
            // 'stamp' => $request->route('id')
            //Ripon@Tech441f! Ripon@Tech2022! ked441f! Ripon@mail2022, moses.M441f!, Ked441f!2022, KampalaUganda
        ]);
    }

}
