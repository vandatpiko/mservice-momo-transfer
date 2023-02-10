<?php

return [
    'guard' => null,
    /**
     * Default model name
     *
     */
    'model'         => VandatPiko\Mservice\Models\MserviceMomo::class,
    /**
     *
     * Default database name
     */

    'table'         => 'mservice_momos',
    /**
     * Version number
     */

    'app_version'   => 40144,

    /**
     * Appcode
     */

    'app_code'      => '4.0.14',

    /**
     * Device name
     */
    'device'        => 'iPhone 14 Pro Max',

    /**
     *  Hardware version
     */
    'hardware'      => 'iPhone',

    /**
     *  Facture name
     */
    'facture'       => 'Apple',
    /**
     * Details of product
     */

    'details' => [
        'cname'     => 'Vietnam',

        'ccode'     => '084',

        'firmware'  => '23',

        'csp'       => 'Viettel',

        'icc'       => '',

        'mcc'       => '452',

        'device_os' => 'ios',
    ],
    /**
     * Timeout in seconds
     */
    'timeout' => 10
];
