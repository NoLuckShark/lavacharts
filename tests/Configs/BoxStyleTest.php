<?php

namespace Khill\Lavacharts\Tests\Configs;

use \Khill\Lavacharts\Configs\BoxStyle;
use \Mockery as m;

class BoxStyleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->bs = new BoxStyle;

        $this->mockGradient = $this->getMock(  //TODO no mocks!
            '\Khill\Lavacharts\Configs\Gradient',
            ['__construct']
        );
    }

    public function testConstructorValuesAssignment()
    {
        $boxStyle = new BoxStyle([
            'stroke'      => '#5B5B5B',
            'strokeWidth' => '5',
            'rx'          => '10',
            'ry'          => '10',
            'gradient'    => $this->mockGradient //TODO no mock!
        ]);

        $this->assertEquals('#5B5B5B', $boxStyle->stroke);
        $this->assertEquals('5', $boxStyle->strokeWidth);
        $this->assertEquals('10', $boxStyle->rx);
        $this->assertEquals('10', $boxStyle->ry);
        $this->assertInstanceOf('\Khill\Lavacharts\Configs\Gradient', $boxStyle->gradient);
    }

    /**
     * @expectedException \Khill\Lavacharts\Exceptions\InvalidConfigProperty
     */
    public function testConstructorWithInvalidPropertiesKey()
    {
        new BoxStyle(['Lasagna' => '50%']);
    }

    public function testStokeWithNumericParams()
    {
        $this->bs->stroke('#DE02FB');

        $this->assertEquals('#DE02FB', $this->bs->stroke);
    }

    /**
     * @dataProvider numericParamsProvider
     */
    public function testStokeWidthWithNumericParams($testNum)
    {
        $this->bs->strokeWidth($testNum);

        $this->assertEquals($testNum, $this->bs->strokeWidth);
    }

    /**
     * @dataProvider numericParamsProvider
     */
    public function testRxWithNumericParams($testNum)
    {
        $this->bs->rx($testNum);

        $this->assertEquals($testNum, $this->bs->rx);
    }

    /**
     * @dataProvider numericParamsProvider
     */
    public function testRyWithNumericParams($testNum)
    {
        $this->bs->ry($testNum);

        $this->assertEquals($testNum, $this->bs->ry);
    }

    /**
     * @expectedException \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @dataProvider badParamsProvider
     */
    public function testStrokeWithBadParams($badVals)
    {
        $this->bs->stroke($badVals);
    }

    /**
     * @expectedException \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @dataProvider badParamsProvider
     */
    public function testStokeWidthWithBadParams($badVals)
    {
        $this->bs->strokeWidth($badVals);
    }

    /**
     * @expectedException \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @dataProvider badParamsProvider
     */
    public function testRxWithBadParams($badVals)
    {
        $this->bs->rx($badVals);
    }

    /**
     * @expectedException \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @dataProvider badParamsProvider
     */
    public function testRyWithBadParams($badVals)
    {
        $this->bs->ry($badVals);
    }


    public function badParamsProvider()
    {
        return [
            [[]],
            [new \stdClass],
            [true],
            [null]
        ];
    }

    public function numericParamsProvider()
    {
        return [
            [123],
            ['123']
        ];
    }
}
