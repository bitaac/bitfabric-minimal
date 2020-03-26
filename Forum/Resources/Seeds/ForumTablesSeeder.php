<?php

namespace Bitaac\Forum\Resources\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('__bitaac_forum_boards');

        if (! $table->where('news', 1)->exists()) {
            $table->insert([
                'title'       => 'Latest News',
                'slug'        => 'latest-news',
                'description' => 'Here you\'ll find all of our latest announcements.',
                'news'        => 1,
            ]);
        }
    }
}
