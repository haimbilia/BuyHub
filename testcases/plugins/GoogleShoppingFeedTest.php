<?php

class GoogleShoppingFeedTest extends YkPluginTest
{
    public const KEY_NAME = 'GoogleShoppingFeed';

    /**
     * testAgeGroup
     *
     * @dataProvider inputAgeGroup
     * @param  mixed $langId
     * @return void
     */
    public function testAgeGroup($langId)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId()], 'ageGroup', [$langId]);
        $this->assertIsArray($response);
    }
        
    /**
     * inputAgeGroup
     *
     * @return array
     */
    public function inputAgeGroup(): array
    {
        return [
            [1], // Return array with values
            [2], // Return array with values if values set for language id 2
            [0],   // Return array with values,
            ['a'],   // Return array with values,
        ];
    }
    
    /**
     * testGetProductCategory
     *
     * @dataProvider inputProductCategory
     * @param  mixed $userId
     * @param  mixed $keyword
     * @param  mixed $returnFullArray
     * @return void
     */
    public function testGetProductCategory($userId, $keyword, $returnFullArray)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId(), $userId], 'getProductCategory', [$keyword, $returnFullArray]);
        $this->assertIsArray($response);
    }
    
    /**
     * inputProductCategory
     *
     * @return array
     */
    public function inputProductCategory(): array
    {
        return [
            [4, 12, true], // Return empty array if invalid type values passed. Return invalid argument type error by actual method.
            [4, 123, false], // Return empty array if invalid type values passed. Return invalid argument type error by actual method.
            [4, '', false], // Return empty array.
            [0, 'phone', false],    // Return array. Invalid user.
            [4, 'case', false], // Return array. Valid user.
            [4, 'phone', true], // Return array. Valid user.
        ];
    }
    
    /**
     * testPublishBatch
     *
     * @dataProvider inputPublishBatch
     * @param  mixed $expected
     * @param  mixed $userId
     * @param  mixed $data
     * @return void
     */
    public function testPublishBatch($expected, $userId, $data)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId(), $userId], 'publishBatch', [$data]);
        $status = empty($response) ? 0 : $response['status'];
        $this->assertEquals($expected, $status);
    }
    
    /**
     * inputPublishBatch
     *
     * @return array
     */
    public function inputPublishBatch(): array
    {
        return [
            [0, 4, []], // Return 0. No Data
            [0, 4, ['abc']], // Return 0. Invalid Data Format.
            [0, 4, ['data' => []]], // Return 0. Missing Data.
            [1, 4, [   
                    'batchId' => 1,
                    'currency_code' => 'USD',
                    'data' => [
                                [
                                    'selprod_id' => '180',
                                    'selprod_title' => 'Apple iPhone 12',
                                    'selprod_stock' => 'in stock',
                                    'selprod_condition' => 'New',
                                    'selprod_price' => '550.00',
                                    'selprod_available_from' => '2020-12-23 00:00:00',
                                    'product_id' => '76',
                                    'product_description' => '
                                        6.1-inch Super Retina XDR display                                            
                                        Ceramic Shield, tougher than any smartphone glass    
                                        A14 Bionic chip, the fastest chip ever in a smartphone 
                                        Advanced dual-camera system with 12MP Ultra Wide and Wide cameras; Night mode, Deep Fusion, Smart HDR 3, 4K Dolby Vision HDR recording
                                        12MP TrueDepth front camera with Night mode, 4K Dolby Vision HDR recording
                                        Industry-leading IP68 water resistance                                            
                                        Supports MagSafe accessories for easy attach and faster wireless charging
                                        iOS with redesigned widgets on the Home screen, all-new App Library, App Clips and more',
                                    'product_upc' => '',
                                    'language_code' => 'EN',
                                    'country_code' => 'US',
                                    'brand_name' => 'Apple',
                                    'abprod_item_group_identifier' => 'APPLE76',
                                    'adsbatch_expired_on' => '2021-01-22 00:00:00',
                                    'abprod_cat_id' => '7',
                                    'optionsData' => [
                                        [
                                            [
                                                'optionvalue_identifier' => '256 GB',
                                                'option_is_color' => '0',
                                                'option_name' => 'Storage',
                                            ]
                                        ],
                                        [
                                            [
                                                'optionvalue_identifier' => 'Gold',
                                                'option_is_color' => '1',
                                                'option_name' => 'Color',
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                ]
            ], // Return 1. Success
            [0, 4, [   
                'batchId' => 1,
                'currency_code' => '',
                'data' => [
                            [
                                'selprod_id' => '180',
                                'selprod_title' => 'Apple iPhone 12',
                                'selprod_stock' => 'in stock',
                                'selprod_condition' => 'New',
                                'selprod_price' => '550.00',
                                'selprod_available_from' => '2020-12-23 00:00:00',
                                'product_id' => '76',
                                'product_description' => '
                                    6.1-inch Super Retina XDR display                                            
                                    Ceramic Shield, tougher than any smartphone glass    
                                    A14 Bionic chip, the fastest chip ever in a smartphone 
                                    Advanced dual-camera system with 12MP Ultra Wide and Wide cameras; Night mode, Deep Fusion, Smart HDR 3, 4K Dolby Vision HDR recording
                                    12MP TrueDepth front camera with Night mode, 4K Dolby Vision HDR recording
                                    Industry-leading IP68 water resistance                                            
                                    Supports MagSafe accessories for easy attach and faster wireless charging
                                    iOS with redesigned widgets on the Home screen, all-new App Library, App Clips and more',
                                'product_upc' => '',
                                'language_code' => 'EN',
                                'country_code' => 'US',
                                'brand_name' => 'Apple',
                                'abprod_item_group_identifier' => 'APPLE76',
                                'adsbatch_expired_on' => '2021-01-22 00:00:00',
                                'abprod_cat_id' => '7',
                                'optionsData' => [
                                    [
                                        [
                                            'optionvalue_identifier' => '256 GB',
                                            'option_is_color' => '0',
                                            'option_name' => 'Storage',
                                        ]
                                    ],
                                    [
                                        [
                                            'optionvalue_identifier' => 'Gold',
                                            'option_is_color' => '1',
                                            'option_name' => 'Color',
                                        ]
                                    ]
                                ]
                            ]
                        ]
                ]
            ], // Return 0 if empty currency code
            [0, 4, [   
                'batchId' => 1,
                'currency_code' => 'USD',
                'data' => [
                            [
                                'selprod_id' => '180',
                                'selprod_title' => 'Apple iPhone 12',
                                'selprod_stock' => 'in stock',
                                'selprod_condition' => 'New',
                                'selprod_price' => '550.00',
                                'selprod_available_from' => '2020-12-23 00:00:00',
                                'product_id' => '76',
                                'product_description' => '
                                    6.1-inch Super Retina XDR display                                            
                                    Ceramic Shield, tougher than any smartphone glass    
                                    A14 Bionic chip, the fastest chip ever in a smartphone 
                                    Advanced dual-camera system with 12MP Ultra Wide and Wide cameras; Night mode, Deep Fusion, Smart HDR 3, 4K Dolby Vision HDR recording
                                    12MP TrueDepth front camera with Night mode, 4K Dolby Vision HDR recording
                                    Industry-leading IP68 water resistance                                            
                                    Supports MagSafe accessories for easy attach and faster wireless charging
                                    iOS with redesigned widgets on the Home screen, all-new App Library, App Clips and more',
                                'product_upc' => '',
                                'language_code' => 'EN',
                                'country_code' => 'XX',
                                'brand_name' => 'Apple',
                                'abprod_item_group_identifier' => 'APPLE76',
                                'adsbatch_expired_on' => '2021-01-22 00:00:00',
                                'abprod_cat_id' => '7',
                                'optionsData' => [
                                    [
                                        [
                                            'optionvalue_identifier' => '256 GB',
                                            'option_is_color' => '0',
                                            'option_name' => 'Storage',
                                        ]
                                    ],
                                    [
                                        [
                                            'optionvalue_identifier' => 'Gold',
                                            'option_is_color' => '1',
                                            'option_name' => 'Color',
                                        ]
                                    ]
                                ]
                            ]
                        ]
                ]
            ], // Return 0 if invalid country code : XX
        ];
    }
}
