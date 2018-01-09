<?php

namespace Ecomail\ChimpDrill\Tests;

use Ecomail\ChimpDrill\ChimpDrill;

class ArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataProvider()
    {
        return array(
            array(
                'message' => 'Empty *|IF:#ECM_BASKET=1|* 1 *|END:IF|*',
                'placeholder' => array(),
                'expected' => 'Empty '
            ),
            array(
                'message' => 'Has *|IF:#ECM_BASKET=1|*1*|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some']
                ),
                'expected' => 'Has 1'
            ),
            array(
                'message' => 'Has *|IF:#ECM_BASKET>1|*more*|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some', 'thing']
                ),
                'expected' => 'Has more'
            ),
            array(
                'message' => 'Has less*|IF:#ECM_BASKET<3|*more*|END:IF|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['some', 'thing', 'some', 'thing']
                ),
                'expected' => 'Has less'
            ),
            array(
                'message' => 'Has *|ECM_BASKET[1]|*',
                'placeholder' => array(
                    'ECM_BASKET' => ['blabla', 'something']
                ),
                'expected' => 'Has something'
            )
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