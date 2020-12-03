<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\User;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(storage_path('app/public/category.json'));

        $data = json_decode($json);

        foreach ($data as $obj)
        {
               Category::Create([
                   'type'=>$obj->type,
                   'name'=>$obj->name
               ]);
        }
        User::Create([
          'name' =>'admin',
          'email'  =>'admin@gmail.com',
            'password'=>Hash::make('admin123'),
            'country_code'=>962,
            'phone_code'=>799887766,
            'user_image'=>'walletAdmin.jpg',
            'isAdmin'=>1
        ]);
    }
}
