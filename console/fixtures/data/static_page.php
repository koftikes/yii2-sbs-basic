<?php

use sbs\helpers\TransliteratorHelper;

$date = \date('Y-m-d H:i:s');

if (!\function_exists('generate')) {
    function generate($slug)
    {
        return \mb_strtolower(TransliteratorHelper::process(\str_replace(' ', '-', $slug)));
    }
}

return [
    'about'       => [
        'id'          => 1,
        'title'       => 'About',
        'slug'        => generate('About'),
        'text'        => 'This is the About page. You can modify content from Admin Panel.',
        'update_date' => $date,
    ],
    'user_agreement' => [
        'id'          => 2,
        'title'       => 'User Agreement',
        'slug'        => generate('User Agreement'),
        'text'        => 'This is the User Policy page. You can modify content from Admin Panel.',
        'update_date' => $date,
    ],

];
