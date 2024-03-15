<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsPage;
class CsmPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cmsPagesRecords=[
            ['id'=>1,'title'=>'Abount Us','description'=>'Content is coming soon','url'=>'abount-us','meta_title'=>'Abount Us','meta_description'=>'Abount Us Content','meta_keywords'=>'about us,abount','status'=>1],
            ['id'=>2,'title'=>'Terms & Conditions','description'=>'Content is coming soon','url'=>'terms-conditions','meta_title'=>'Terms & Conditions','meta_description'=>'Terms & Conditions Content','meta_keywords'=>'terms,terms conditions','status'=>1],
            ['id'=>3,'title'=>'Privacy Policy','description'=>'Content is coming soon','url'=>'privacy-policy','meta_title'=>'Privacy Policy','meta_description'=>'Privacy Policy Content','meta_keywords'=>'privacy policy','status'=>1],
        ];
        // thêm dữ liệu vào bảng
        CmsPage::insert($cmsPagesRecords);
    }
}
