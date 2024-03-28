<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productsRecords=[
            ['id'=>1,'category_id'=>6,'brand_id'=>0,'product_name'=>'Blue T-Shirt','product_code'=>'BT01','product_color'=>'Dark Blue','family_color'=>'Blue','group_code'=>'TSHIRT0000','product_price'=>1500,'product_weight'=>500,'product_discount'=>'10','discount_type'=>'product','final_price'=>1350,'product_video'=>'','description'=>'Test Product','wash_care'=>'','keywords'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','mete_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1,],
            ['id'=>2,'category_id'=>3,'brand_id'=>0,'product_name'=>'Blue T-Shirt','product_code'=>'BT01','product_color'=>'Dark Blue','family_color'=>'Blue','group_code'=>'TSHIRT0000','product_price'=>1500,'product_weight'=>500,'product_discount'=>'10','discount_type'=>'product','final_price'=>1350,'product_video'=>'','description'=>'Test Product','wash_care'=>'','keywords'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','mete_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1,],

        ];
        Product::insert($productsRecords);
    }
}
