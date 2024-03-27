<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoryRecords = [
            ['id'=>7,'parent_id'=>2,'category_name'=>'Woman','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>8,'parent_id'=>2,'category_name'=>'Kid','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>9,'parent_id'=>2,'category_name'=>'Kid','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>10,'parent_id'=>2,'category_name'=>'Kid','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>11,'parent_id'=>2,'category_name'=>'Kid','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>12,'parent_id'=>2,'category_name'=>'Kid','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'clothing','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
           
        ];
        Category::insert($categoryRecords);
    }
}
