<?php

namespace Ecomail\ChimpDrill\Tests;

use Ecomail\ChimpDrill\ChimpDrill;

class ArrayNewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataProvider()
    {
        return array(
            array(
                'message' => 'Empty *|IF:ECM_BASKET[1]|* 1 *|END:IF|*',
                'placeholder' => array(),
                'expected' => 'Empty '
            ),
            array(
                'message' => 'Has *|IF:ECM_BASKET[1]|* 1 *|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some']
                ),
                'expected' => 'Has  1 '
            ),
            array(
                'message' => 'Has *|IF:ECM_BASKET = 1|* more *|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some', 'thing']
                ),
                'expected' => 'Has '
            ),
            array(
                'message' => 'Has *|IF:ECM_BASKET > 1|* more *|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some', 'thing']
                ),
                'expected' => 'Has  more '
            ),
            array(
                'message' => 'Has *|IF:ECM_BASKET > 3|* more *|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some', 'thing', 'some', 'thing']
                ),
                'expected' => 'Has  more '
            ),
            array(
                'message' => 'Has *|ECM_BASKET[1]|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['blabla', 'something']
                ),
                'expected' => 'Has blabla'
            ),
            array(
                'message' => '
                    *|ECM_COUPON|*
                    *|NAME|*
                    *|SURNAME|*
                    *|AGE|*
                    *|VLASTNIK|*
                    *|CITY|*
                    *|IF:ECM_LAST_VIEW[1]|*
                        Naposledy jste u nás prohlíželi:
                        *|IF:ECM_LAST_VIEW=1|*
                            *|ECM_LAST_VIEW[1].name|*
                            *|ECM_LAST_VIEW[1].price|* Kč
                        *|ELSE:|*
                            *|ECM_LAST_VIEW[1].name|*
                            *|ECM_LAST_VIEW[1].price|* Kč
                            
                            *|ECM_LAST_VIEW[2].name|*
                            *|ECM_LAST_VIEW[2].price|* Kč
                        *|END:IF|*
                    *|END:IF|*',
                'placeholder' => array(
                    "EMAIL" => "some@email.com",
                    "NAME" => "Bramborova",
                    "SURNAME" => "Kase",
                    "COMPANY" => "",
                    "ECMID" => 1,
                    "STREET" => "",
                    "CITY" => "",
                    "ZIP" => "",
                    "COUNTRY" => "",
                    "BIRTHDAY" => "0000-00-00",
                    "SURTITLE" => "",
                    "PRETITLE" => "",
                    "PHONE" => "",
                    "NAMEDAY" => "09-29",
                    "VOKATIV" => "Bramborova",
                    "VOKATIV_S" => "Kase",
                    "GENDER" => "male",
                    "CONNECTION_ID" => 61536,
                    "URL" => "",
                    "SHOP" => "",
                    "JHGFDS" => "",
                    "VLASTNIK" => "a",
                    "DATENEVIM" => "2000-02-02",
                    "ECM_COUPON" => "523452525",
                    "ECM_LAST_VIEW" => [
                        [
                            "name" => "noha",
                            "price" => 123,
                        ],
                        [
                            "name" => "ruka",
                            "price" => 456,
                        ],
                    ],
                    "AGE" => "",
                    "IF:ECM_LAST_VIEW[1]" => "",
                    "IF:ECM_LAST_VIEW=1" => "",
                    "ECM_LAST_VIEW[1].NAME" => "",
                    "ECM_LAST_VIEW[1].PRICE" => "",
                    "ELSE:" => "",
                    "ECM_LAST_VIEW[2].NAME" => "",
                    "ECM_LAST_VIEW[2].PRICE" => "",
                    "END:IF" => "",
                ),
                'expected' => '                    523452525
                    Bramborova
                    Kase
                    
                    a
                    
                                            Naposledy jste u nás prohlíželi:
                                                    noha
                            123 Kč
                            
                            ruka
                            456 Kč
                                            '
            ),
        );
    }

    /**
     * @param string $message
     * @param array  $placeholder
     * @param string $expected
     *
     * @dataProvider dataProvider
     */
    public function testArrayMergeTags($message, array $placeholder, $expected)
    {
        $this->assertEquals($expected, (string) new ChimpDrill($message, $placeholder));
    }
}