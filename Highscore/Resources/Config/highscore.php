<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Player group IDs to ignore. 
    |--------------------------------------------------------------------------
    |
    |
    */

    'ignore-group-ids' => [2, 3], 

    /*
    |--------------------------------------------------------------------------
    | Pagination per page
    |--------------------------------------------------------------------------
    |
    |
    */

    'per-page' => 15,

    /*
    |--------------------------------------------------------------------------
    | Holds the skills and its respective ID
    |--------------------------------------------------------------------------
    | 'url-param' => 'table-column' besides from experience & magic level, they
    |  are hard coded values.
    |
    */

    'skills' => [
        'fist'             => 'skill_fist',
        'club'             => 'skill_club',
        'sword'             => 'skill_sword',
        'axe'             => 'skill_axe',
        'distance'         => 'skill_dist',
        'shielding'         => 'skill_shielding',
        'fishing'         => 'skill_fishing',
        'experience'     => 7,
        'maglevel'         => 8,
    ],

    /*
    |--------------------------------------------------------------------------
    | Holds the skills and its respective presentable
    |--------------------------------------------------------------------------
    | 'url-param' => 'presentable'
    |
    */

    'skills-presentable' => [
        'fist'             => 'Fist Fighting',
        'club'             => 'Club Fighting',
        'sword'             => 'Sword Fighting',
        'axe'             => 'Axe Fighting',
        'distance'         => 'Distance Fighting',
        'shielding'         => 'Shielding',
        'fishing'         => 'Fishing',
        'experience'     => 'Experience',
        'maglevel'         => 'Magic Level',
    ],

];
