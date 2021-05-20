<?php

class EasyPostTest extends YkPluginTest
{
    public const KEY_NAME = 'EasyPost';
    public const PLUGIN_TYPE = Plugin::TYPE_SHIPPING_SERVICES;

    private $feedValues = [];
    private $resp = [];
    private $shipment = [];

    /**
     * init
     *
     * @param  mixed $method - Called before execution. Treet as a setter function.
     * @return void
     */
    public function init(string $method = '')
    {   
        $this->classObj->init();   

        if (!empty($this->feedValues)) {
            switch ($method) {
                case 'getRates':
                    $fromAddress = $this->feedValues['from_address'];
                    if (0 < count($fromAddress)) {
                        $this->classObj->setAddress($fromAddress['name'], $fromAddress['street1'], $fromAddress['street2'], $fromAddress['city'], $fromAddress['state'], $fromAddress['zip'], $fromAddress['country'], $fromAddress['phone']);
                    }

                    $toAddress = $this->feedValues['to_address'];
                    if (0 < count($toAddress)) {
                        $this->classObj->setFromAddress($toAddress['name'], $toAddress['street1'], $toAddress['street2'], $toAddress['city'], $toAddress['state'], $toAddress['zip'], $toAddress['country'], $toAddress['phone']);
                    }
                    $this->classObj->setQuantity(1);
                    $shipment = (array) array_key_exists('shipments', $this->feedValues) && 0 < count($this->feedValues['shipments']) ? current($this->feedValues['shipments']) : [];

                    if (0 < count($shipment) && array_key_exists('parcel', $shipment) && 0 < count($shipment['parcel'])) {
                        $parcel = $shipment['parcel'];
                        $this->classObj->setDimensions($parcel['length'], $parcel['width'], $parcel['height']);
                        $this->classObj->setWeight($parcel['weight']);
                    }
                    break;
                case 'proceedToShipment':
                    $this->classObj->setShipment($this->shipment);
                    break;
                default:
                    /* Set Test Keys to method of called class. */
                    $this->classObj->settings = $this->feedValues;   
                    /* Set Test Keys to method of called class. */
                    break;
            }
        }
    }

    /**
     * inputFeeder :  This function is used to test validation based on given keys.
     *
     * @param  string $action
     * @return array
     */
    private function inputFeeder(string $dataProvider): array
    {
        return [
            [
                true,
                [
                    'env' => 0,
                    'plugin_active' => 1,
                    'api_key' => 'EZTKb5258b08c21a4753b46a47ddee97a993TaJ0Hxak0ZODrCrUsbdH0g',
                    'live_api_key' => 'EZAKb5258b08c21a4753b46a47ddee97a993ulau3dnh4A139LHWyapcxA',
                ],
            ], // Return TRUE. Everything is correct. Return False if plan expires.
            [
                false,
                [
                    'env' => 0,
                    'plugin_active' => 0,
                    'api_key' => 'EZTKb5258b08c21a4753b46a47ddee97a993TaJ0Hxak0ZODrCrUsbdH0g',
                    'live_api_key' => 'EZAKb5258b08c21a4753b46a47ddee97a993ulau3dnh4A139LHWyapcxA',
                ],
            ], // Return FALSE. Plugin Inactive.
            [
                ('feedInit' == $dataProvider),
                [
                    'env' => 0,
                    'plugin_active' => 1,
                    'api_key' => 'XXX',
                    'live_api_key' => 'XXX',
                ],
            ], // Return TRUE. Plugin Active but invalid api key. Doesn't validate key.
            [
                false,
                [
                    'env' => 0,
                    'plugin_active' => 1,
                    'api_key' => '',
                    'live_api_key' => '',
                ],
            ], // Return false. Plugin Active but empty api key.
            [
                false,
                [
                    'env' => 0,
                    'plugin_active' => 0,
                    'api_key' => '',
                    'live_api_key' => '',
                ],
            ], // Return false. Plugin Inactive and empty api key.
        ];
    }

    /**
     * feedInit
     *
     * @return array
     */
    public function feedInit(): array
    {
        return $this->inputFeeder(__FUNCTION__);
    }

    /**
     * @test
     *
     * @dataProvider feedInit
     * @param  mixed $expected
     * @param  mixed $feed
     * @return void
     */
    public function pluginInit($expected, $feed)
    {
        $this->feedValues = $feed;
        $response = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], 'init');
        $this->assertEquals($expected, $response);
    }

    /**
     * executeAssertionOnArray
     *
     * @param  string $function
     * @param  mixed $expected
     * @param  array $functionParams
     * @return void
     */
    private function executeAssertionOnArray($function, $expected, $functionParams = [])
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->resp = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], $function, $functionParams);

        $this->assertIsArray($this->resp);
        if (false === $expected) {
            $this->assertCount(0, $this->resp);
        } else {
            $this->assertGreaterThan(0, count($this->resp));
        }
        $status = (!empty($this->resp) && 0 < count($this->resp));
        $this->assertEquals($expected, $status);
    }

    /**
     * feedGetCarriers
     *
     * @return array
     */
    public function feedGetCarriers(): array
    {
        return $this->inputFeeder(__FUNCTION__);
    }

    /**
     * @test
     *
     * @dataProvider feedGetCarriers
     * @param  mixed $expected
     * @param  mixed $feed
     * @return void
     */
    public function getCarriers($expected, $feed)
    {
        $this->feedValues = $feed;
        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->executeAssertionOnArray(__FUNCTION__, $expected);
    }

    /**
     * feedGetRates
     *
     * @return array
     */
    public function feedGetRates(): array
    {
        return [
            [
                true, /* Everything Correct */
                [
                    'from_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [
                        'name' => 'Barbara',
                        'street1' => 'Elegance Store, Tempe Market Place',
                        'street2' => '2000 East Rio Salado Parkway',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+2139876543210',
                    ],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                true,  /* From & To Address Both Are Same. */
                [
                    'from_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                false,  /* From & To Address Both Are Invalid. */
                [
                    'from_address' => [
                        'name' => 'XXX',
                        'street1' => 'XXX',
                        'street2' => 'XXX',
                        'city' => 'XXX',
                        'state' => 'XXX',
                        'zip' => 'XXX',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [
                        'name' => 'XXX',
                        'street1' => 'XXX',
                        'street2' => 'XXX',
                        'city' => 'XXX',
                        'state' => 'XXX',
                        'zip' => 'XXX',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                false,  /* Empty To Address. */
                [
                    'from_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                false,  /* Empty From Address. */
                [
                    'from_address' => [],
                    'to_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                false,  /* Empty From & To Address. */
                [
                    'from_address' => [],
                    'to_address' => [],
                    'shipments' => [
                        '0' =>[
                            'parcel' => [
                                'length' => '25.00',
                                'width' => '2.00',
                                'height' => '20.00',
                                'weight' => '352.74',
                            ]
                        ]
                    ]
                ]
            ],
            [
                false,  /* Empty Parcel. */
                [
                    'from_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'shipments' => [
                        '0' =>[
                            'parcel' => []
                        ]
                    ]
                ]
            ],
            [
                false,  /* Empty Shipment. */
                [
                    'from_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'to_address' => [
                        'name' => '7-Eleven',
                        'street1' => '485 W. WARNER ROAD',
                        'street2' => '',
                        'city' => 'Tempe',
                        'state' => 'Arizona',
                        'zip' => '85281',
                        'country' => 'US',
                        'phone' => '+54565412300',
                    ],
                    'shipments' => []
                ]
            ],
            [
                false,  /* All Empty. */
                [
                    'from_address' => [],
                    'to_address' => [],
                    'shipments' => []
                ]
            ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider feedGetRates
     * @param  mixed $expected
     * @param  mixed $feed
     * @return void
     */
    public function getRates($expected, $feed)
    {
        $this->feedValues = $feed;
        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->executeAssertionOnArray(__FUNCTION__, $expected, $feed);
    }

    /**
     * @test
     *
     * @return void
     */
    public function retrieveOrder()
    {
        $this->feedValues = [
            'from_address' => [
                'name' => '7-Eleven',
                'street1' => '485 W. WARNER ROAD',
                'street2' => '',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '+919876543210',
            ],
            'to_address' => [
                'name' => 'Barbara',
                'street1' => 'Elegance Store, Tempe Market Place',
                'street2' => '2000 East Rio Salado Parkway',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '+919876543210',
            ],
            'shipments' => [
                '0' =>[
                    'parcel' => [
                        'length' => '25.00',
                        'width' => '2.00',
                        'height' => '20.00',
                        'weight' => '352.74',
                    ]
                ]
            ]
        ];

        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->executeAssertionOnArray('getRates', true, [$this->feedValues]);

        $rate = (array) (is_array($this->resp) && 0 < count($this->resp) ? current($this->resp) : ['shipmentId' => '']);
        $feed = !empty($rate['shipmentId']) ? explode('|', $rate['shipmentId'])[0] : '';
        $expected = empty($feed) ? false : true;

        $this->expectedReturnType(static::TYPE_BOOL);
        $response = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], __FUNCTION__, [$feed]);
        $this->assertEquals($expected, $response);
    }

    /**
     * @test
     *
     * @return void
     */
    public function retrieveRate()
    {
        $this->feedValues = [
            'from_address' => [
                'name' => '7-Eleven',
                'street1' => '485 W. WARNER ROAD',
                'street2' => '',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '+919876543210',
            ],
            'to_address' => [
                'name' => 'Barbara',
                'street1' => 'Elegance Store, Tempe Market Place',
                'street2' => '2000 East Rio Salado Parkway',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '+919876543210',
            ],
            'shipments' => [
                '0' =>[
                    'parcel' => [
                        'length' => '25.00',
                        'width' => '2.00',
                        'height' => '20.00',
                        'weight' => '352.74',
                    ]
                ]
            ]
        ];
        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->executeAssertionOnArray('getRates', true, [$this->feedValues]);

        $rate = (array) (is_array($this->resp) && 0 < count($this->resp) ? current($this->resp) : ['shipmentId' => '']);
        $feed = $rate['shipmentId'];
        $expected = empty($feed) ? false : true;

        $this->executeAssertionOnArray(__FUNCTION__, $expected, [$feed, true]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function loadOrder()
    {
        $this->feedValues = [
            'from_address' => [
                'name' => '7-Eleven',
                'street1' => '485 W. WARNER ROAD',
                'street2' => '',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '9876543210',
            ],
            'to_address' => [
                'name' => 'Barbara',
                'street1' => 'Elegance Store, Tempe Market Place',
                'street2' => '2000 East Rio Salado Parkway',
                'city' => 'Tempe',
                'state' => 'Arizona',
                'zip' => '85281',
                'country' => 'US',
                'phone' => '9876543210',
            ],
            'shipments' => [
                '0' =>[
                    'parcel' => [
                        'length' => '25.00',
                        'width' => '2.00',
                        'height' => '20.00',
                        'weight' => '352.74',
                    ]
                ]
            ]
        ];
        $this->expectedReturnType(static::TYPE_ARRAY);
        $this->executeAssertionOnArray('getRates', true, [$this->feedValues]);
        
        $rate = (array) (is_array($this->resp) && 0 < count($this->resp) ? current($this->resp) : ['shipmentId' => '']);
        $feed = $rate['shipmentId'];
        $expected = empty($feed) ? false : true;
        
        $this->expectedReturnType(static::TYPE_BOOL);
        $resp = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], __FUNCTION__, [$feed]);
        $this->assertEquals($expected, $resp);
        $this->shipment = $this->classObj->getShipment();
    }

    /**
     * @test
     *
     * @return void
     */
    public function proceedToShipment()
    {
        /* Load Order */
        $this->loadOrder();
        $rate = (array) (is_array($this->resp) && 0 < count($this->resp) ? current($this->resp) : ['shipmentId' => '']);

        /* Proceed to Shipment */
        $shipmentFeed = ['opshipmentId' => $rate['shipmentId']];
        $response = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], __FUNCTION__, [$shipmentFeed]);
        $this->assertEquals(true, $response);
    }
}
