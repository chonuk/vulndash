<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Plataforma;
use App\Activo;

class ExcelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function exportFile($type){
        $products = Product::get()->toArray();

        return \Excel::create('hdtuto_demo', function($excel) use ($products) {
            $excel->sheet('sheet name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
            });
        })->download($type);
    }      
}