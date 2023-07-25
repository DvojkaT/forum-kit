<?php

namespace DvojkaT\Forumkit\database\seeders;

use DvojkaT\Forumkit\Models\ThreadCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ThreadCategorySeeder extends Seeder
{
    public function run(): void
    {
        ThreadCategory::query()->firstOrCreate(['title' => 'Тру стори', 'slug' => Str::slug('Тру стори')]);
    }
}
