<?php

if (! function_exists('gender')) {
    /**
      * Convert gender ID to human-readable format.
      *
      * @return string
      */
     function gender($id)
     {
         return config("bitaac.server.genders.${id}");
     }
}

if (! function_exists('vocation')) {
    /**
      * Convert vocation ID to human-readable format.
      *
      * @param int|string  $id
      * @param bool  $reverse
      * @return string
      */
     function vocation($id, $reverse = false)
     {
         if (! $reverse) {
             return config("bitaac.server.vocations.${id}");
         }

         $id = str_replace('-', ' ', $id);

         $collection = collect(config('bitaac.server.vocations'));

         return key($collection->filter(function ($value, $key) use ($id) {
             if (strtolower($value) == urldecode($id)) {
                 return $key;
             }
         })->all());
     }
}

if (! function_exists('town')) {
    /**
      * Convert town ID to humad-readable format.
      *
      * @return string
      */
     function town($id)
     {
         return config("bitaac.server.towns.${id}");
     }
}

if (! function_exists('value_args')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @param  array $args []
     * @return mixed
     */
    function value_args($value, $args = [])
    {
        if (! ($value instanceof Closure)) {
            return $value;
        }

        if (! is_array($args)) {
            $args = [$args];
        }

        return call_user_func_array($value, $args);
    }
}

if (! function_exists('formulae')) {
    /**
     * Create a function to calculate common formulas.
     *
     * @param  string $formula
     * @param  \Player $player
     * @param  array $args false
     * @return mixed
     */
    function formulae($formula, \Bitaac\Contracts\Player $player, $value = false)
    {
        switch (strtolower($formula)) {
            case 'maglevel':
                return [$value, 0];
            case 'health':
                return 145 + ($player->level >= 8 ? (($player->level - 8) * $value) + (5 * 8) : (5 * $player->level));
            case 'mana':
                return $player->level >= 8 ? (($player->level - 8) * $value) + (5 * 8) : (5 * $player->level);
            case 'capacity':
                return 390 + ($player->level >= 8 ? (($player->level - 8) * $value) + (10 * 8) : (10 * $player->level));
        }
    }
}

if (! function_exists('url_e')) {
    /**
     * Convert a value to a more URL-friendly version.
     *
     * @param  string $value
     * @param  array $arguments []
     * @return string
     */
    function url_e($value, array $arguments = [])
    {
        foreach ($arguments as $key => $argument) {
            $value = preg_replace('/\:'.preg_quote($key, '/').'/i', strtolower(urlencode(e($argument))), $value);
        }

        return str_replace('+', '-', url($value));
    }
}

if (! function_exists('ago')) {
    /**
     * Format a unix timestamp in a 'time ago' format,
     * e.g. 15 minutes ago or 7 days ago.
     *
     * @param  int $time
     * @return string
     */
    function ago($time)
    {
        $config = [
            ['second',     'seconds'],
            ['minute',     'minutes'],
            ['hour',     'hours'],
            ['day',     'days'],
            ['week',     'weeks'],
            ['month',     'months'],
            ['year',     'years'],
            ['decade',     'decades'],
        ];

        list($periods, $lengths, $now) = [$config, [60, 60, 24, 7, 4.35, 12, 10], time()];
        $difference = $now - $time;
        for ($j = 0; $difference >= $lengths[$j] and $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        $period = $difference == 1 ? $periods[$j][0] : $periods[$j][1];
        if ($difference == 0) {
            return 'Just now';
        }

        return "${difference} ${period} ago";
    }
}

if (! function_exists('player')) {
    /**
     * Initialize a new player object by player id.
     *
     * @param  int $player_id
     * @return \Bitaac\Player\Player
     */
    function player($player_id)
    {
        $player = app('player')->where('id', $player_id);

        return ($player->exists()) ? $player->first() : false;
    }
}

if (! function_exists('str_e')) {
    /**
     * Convert a value to a more friendly version.
     *
     * @param  string $value
     * @param  array $arguments []
     * @return string
     */
    function str_e($value, array $arguments = [], $lower = true)
    {
        foreach ($arguments as $key => $argument) {
            $value = preg_replace(
                '/\:'.preg_quote($key, '/').'/i',
                ($lower) ? strtolower($argument) : $argument, $value
            );
        }

        return $value;
    }
}

if (! function_exists('player_value')) {
    /**
     * Determine if $value is a player name, then we will return
     * a link to its view, or we will just return the value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function player_value($value)
    {
        $player = app('player')->where('name', $value);

        return ($player->exists()) ? "<a href='{$player->first()->link()}'>{$value}</a>" : $value;
    }
}

if (! function_exists('lines')) {
    /**
     * Force a maximum amount of lines in a string.
     *
     * @param  string $string
     * @param  int $lines 10
     * @return string
     */
    function lines($string, $lines = 10)
    {
        $i = 0;

        return preg_replace_callback('/\\r\\n/i', function ($value) use (&$i, $lines) {
            if ((++$i) > $lines) {
                return;
            }

            return head($value);
        }, $string);
    }
}

if (! function_exists('server_path')) {
    /**
     * Get the server path.
     *
     * @param string $path
     * @return mixed
     */
    function server_path($path = '') {
        return config('bitaac.server.path').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('config_lua')) {
    /**
     * Get a config.lua value.
     *
     * @param  string                  $string
     * @param  string|integer|boolean  $default
     * @return string|integer|boolean
     */
    function config_lua($key, $default = '')
    {
        static $config = null;

        if (is_null($config)) {
            try {
                $config = collect(file(
                    server_path('config.lua')
                ));
            } catch (Exception $e) {
                return $default;
            }

            $config = parse_ini_string($config->map(function ($item, $index) {
                return ltrim($item);
            })->filter(function ($item, $index) {
                return preg_match('/^([A-Za-z])+\s?=\s?\"?(.*?)+\"?/i', $item);
            })->implode(''));
        }

        return isset($config[$key]) ? $config[$key] : $default;
    }
}

if (! function_exists('getOnlineRecord')) {
    /**
     * Get the server online record.
     *
     * @return integer
     */
    function getOnlineRecord()
    {
        return DB::table('server_config')->where('config', 'players_record')->first()->value;
    }
}

if (! function_exists('isServerOnline')) {
    /**
     * Determine if the OTServer is online.
     *
     * @return boolean
     */
    function isServerOnline()
    {
        return Cache::remember('bitaac:server:status', now()->addSeconds(30), function () {
            @$sock = fsockopen(config('bitaac.server.ip'), config('bitaac.server.port'), $errno, $errstr, 1);

            if (!$sock) {
                return false;
            }

            $info = chr(6).chr(0).chr(255).chr(255).'info';
            fwrite($sock, $info);
            $data='';
            while (!feof($sock))$data .= fgets($sock, 1024);
            fclose($sock);

            return true;
        });
    }
}

if (! function_exists('getOnlinePlayers')) {
    /**
     * Get online players.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getOnlinePlayers()
    {
        return Cache::remember('bitaac:players:online', 10, function () {
            return app('player')->getOnlineList();
        });
    }
}

if (! function_exists('getOnlinePlayersCount')) {
    /**
     * Get online players count.
     *
     * @return boolean
     */
    function getOnlinePlayersCount()
    {
        return getOnlinePlayers()->count();
    }
}
