<?php

return [

    /*
     * Set the names of files you want to add to generated javascript.
     * Otherwise all the files will be included.
     *
     * 'messages' => [
     *     'validation',
     *     'forum/thread',
     * ],
     */
    'messages' => [
        'action',
        'auth',
        'category',
        'editor',
        'general',
        'idea',
        'itinerary',
        'menu',
        'place',
        'pagination',
        'passwords',
        'profile',
        'tag',
        'texts',
        'validation',

    ],

    /*
     * The default path to use for the generated javascript.
     */
    'path' => public_path('/js/localization/messages.js'),
];
