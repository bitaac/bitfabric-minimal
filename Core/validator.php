<?php

/**
 * Determine if config holds the value.
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return bool
 */
Validator::extend('in_config', function ($attribute, $value, $parameters, $validator) {
    return in_array($value, config($parameters[0]));
});

/*
 * Determine if config holds the value as key
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('in_config_key', function ($attribute, $value, $parameters, $validator) {
    return isset(config($parameters[0])[$value]);
});

/*
 * Determine if config not holds the value
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('not_in_config', function ($attribute, $value, $parameters, $validator) {
    //
});

/*
 * Determine if character name contains blacklisted keyword
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('blacklisted', function ($attribute, $value, $parameters, $validator) {
    $blacklist = config('bitaac.character.create-blocked-keywords');

    array_walk($blacklist, function (&$v, $k) {
        $v = preg_quote($v, '/');
    });

    $blacklist = implode('|', $blacklist);

    return ! preg_match('/\b('.$blacklist.')\b/i', $value);
});

/*
 * Determine if forum thread title is valid
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('forum_title', function ($attribute, $value, $parameters, $validator) {
    return preg_match('/^[a-z0-9 ]+$/i', $value);
});

/*
 * Determine if character name is valid
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('charname', function ($attribute, $value, $parameters, $validator) {
    if (str_word_count(trim($value)) > config('bitaac.character.name-maxwords')) {
        return false;
    }

    if (! preg_match('/^([a-zA-Z ]+)$/', $value)) {
        return false;
    }

    $limit = 2;
    if (preg_match('/(\w)\1{'.$limit.',}/i', $value)) {
        return false;
    }

    return true;
});

/*
 * Make sure the value not contains more than images
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('max_images', function ($attribute, $value, $parameters, $validator) {
    if (! isset($parameters[0]) or ! ($limit = (int) $parameters[0])) {
        throw new \Exception('The max_images validation rule requires an integer value as its first parameter.');
    }

    return substr_count(strtolower($value), '<img') <= $limit;
});

/*
 * Make sure the value not contains more than x words.
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('max_words', function ($attribute, $value, $parameters, $validator) {
    if (! isset($parameters[0]) or ! ($limit = (int) $parameters[0])) {
        throw new \Exception('The max_images validation rule requires an integer value as its first parameter.');
    }

    return ! (str_word_count(trim($value)) > $limit);
});

/*
 * Determine if value is only letters and spaces.
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('alpha_space', function ($attribute, $value, $parameters, $validator) {
    return preg_match('/^[\pL\s]+$/u', $value);
});

/*
 * Make sure the player is not in a guild.
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('guildless', function ($attribute, $value, $parameters, $validator) {
    $player = app('player')->find($value);

    if (is_null($player)) {
        return false;
    }

    return (bool) ! $player->guild;
});

/*
 * Validate guild rank name.
 *
 * @param string  $attribute
 * @param mixed   $value
 * @param array   $parameters
 * @param \Illuminate\Validation\Validator  $validator
 * @return boolean
 */
Validator::extend('rankname', function ($attribute, $value, $parameters, $validator) {
    return preg_match('/^[a-zA-Z-]+(\s[a-zA-Z-]*){0,2}$/', $value);
});
