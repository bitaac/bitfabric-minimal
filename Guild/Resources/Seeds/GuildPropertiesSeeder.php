<?php

namespace Bitaac\Guild\Resources\Seeds;

use Illuminate\Database\Seeder;
use Bitaac\Guild\Models\BitGuild;

class GuildPropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guilds = app('guild')->all();

        foreach ($guilds as $guild) {
            if (is_null($guild->slug)) {
                $guild->slug = str_slug($guild->name);
                $guild->save();
            }

            if ($guild->bitaac) {
                continue;
            }

            $bitguild = new BitGuild;
            $bitguild->guild_id = $guild->id;
            $bitguild->save();
        }
    }
}
