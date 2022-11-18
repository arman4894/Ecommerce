<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Category::create([
            'name'=>'laptop',
            'slug'=>'laptop',
            'description'=>'dfgfgjkdgfjkjkfgzjkjgdfdf',
            'image'=>'files/photo.jpg'
        ]);
        Category::create([
            'name'=>'mobile',
            'slug'=>'mobile',
            'description'=>'dfgfgjkdgfjkjkfgzjkjgdfdf',
            'image'=>'files/photo.jpg'
        ]);
        Category::create([
            'name'=>'book',
            'slug'=>'book',
            'description'=>'dfgfgjkdgfjkjkfgzjkjgdfdf',
            'image'=>'files/photo.jpg'
        ]);
        SubCategory::create([
            'name'=>'dell',
            'category_id'=>1
        ]);
        SubCategory::create([
            'name'=>'redmi',
            'category_id'=>2
        ]);
        SubCategory::create([
            'name'=>'samsung',
            'category_id'=>2
        ]);
        Product::create([
            'name'=>'Samsung A2',
            'image'=>'files/photo.jpg',
            'price'=>rand(700,1000),
            'description'=>'gbdjkfgjhghjgdh djgjgdjhfgjh',
            'additional_info'=>'jdbgjkgjhfh hhfufudf',
            'category_id'=>2,
            'subcategory_id'=>2
        ]);
        Product::create([
            'name'=>'redmi A2',
            'image'=>'files/photo.jpg',
            'price'=>rand(800,1000),
            'description'=>'gbdjkfgjhghjgdh djgjgdjhfgjh',
            'additional_info'=>'jdbgjkgjhfh hhfufudf',
            'category_id'=>2,
            'subcategory_id'=>2
        ]);
        Product::create([
            'name'=>'dell A2 laptop',
            'image'=>'files/photo.jpg',
            'price'=>rand(900,2000),
            'description'=>'gbdjkfgjhghjgdh djgjgdjhfgjh',
            'additional_info'=>'jdbgjkgjhfh hhfufudf',
            'category_id'=>1,
            'subcategory_id'=>1
        ]);
        User::create([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin@123'),
            'email_verified_at'=>NOW(),
            'address'=>'f2/4 madrasi colony bhopal',
            'phone_number'=>'7869868835',
            'is_admin'=>1
        ]);
    }
}
