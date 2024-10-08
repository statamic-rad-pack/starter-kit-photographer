<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | List of styles.
    |
    */

    'styles' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Pins (pro only)
    |--------------------------------------------------------------------------
    |
    | List of pins.
    |
    */

    'pins' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Attributes (pro only)
    |--------------------------------------------------------------------------
    |
    | The attributes that can be edited through the attributes panel.
    |
    */

    'attributes' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Defaults
    |--------------------------------------------------------------------------
    |
    | Default styles that will be applied to elements with no style set. It's
    | also possible configure multiple sets of defaults to use with different
    | Bard fields, refer to the docs for more info.
    |
    */

    'defaults' => [

        'standard' => [
            'heading_1' => [
                'class' => 'font-serif text-4xl leading-tight md:text-5xl md:leading-tight xl:text-6xl xl:leading-tight my-8 xl:my-12 2xl:my-16 first:mt-0 last:mb-0',
            ],

            'paragraph' => [
                'class' => 'text-base leading-relaxed md:text-lg md:leading-relaxed my-8 first:mt-0 last:mb-0',
            ],

            'link' => [
                'class' => 'underline decoration-1 underline-offset-2 transition hover:text-gray-500 hover:decoration-gray-500 focus:outline-none focus-visible:ring-1 focus-visible:ring-black focus-visible:rounded',
            ],
        ],

        'cta' => [
            'paragraph' => [
                'class' => 'font-serif text-3xl leading-tight md:text-4xl md:leading-tight xl:text-5xl xl:leading-tight',
            ],

            'link' => [
                'class' => 'underline decoration-2 underline-offset-8 transition hover:text-gray-500 hover:decoration-gray-500 focus:outline-none focus-visible:ring-1 focus-visible:ring-black focus-visible:rounded',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    |
    | By default the class names are saved to your content. If you would prefer
    | to save the style keys instead you can change this option to "key".
    |
    */

    'store' => 'key',

];
