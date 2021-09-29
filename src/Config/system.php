<?php

return [
    [
        'key'    => 'sales.paymentmethods.hyperpay',
        'name'   => 'HyperPay',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'admin::app.admin.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],
            [
                'name'          => 'description',
                'title'         => 'admin::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ],
            [
                'name'          => 'access_token',
                'title'         => 'hyperpay::app.admin.system.access-token',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => false,
            ],
            [
                'name'          => 'entity_id',
                'title'         => 'hyperpay::app.admin.system.entity-id',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => false,
            ],
            [
                'name'          => 'sandbox',
                'title'         => 'hyperpay::app.admin.system.sandbox',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],
            [
                'name'          => 'active',
                'title'         => 'admin::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],
        ],
    ],
];