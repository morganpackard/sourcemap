<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\parsing;

use axy\sourcemap\parsing\Line;
use axy\sourcemap\PosMap;

/**
 * coversDefaultClass axy\sourcemap\parsing\Line
 */
class LineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getPositions
     */
    public function testGetPositions()
    {
        $positions = [
            10 => new PosMap(['line' => 10], null),
            15 => new PosMap(['line' => 15], null),
        ];
        $line = new Line($positions);
        $this->assertEquals($positions, $line->getPositions());
    }

    /**
     * covers ::loadFromPlainList
     */
    public function testLoadFromPlainList()
    {
        $positions = [
            new PosMap(['line' => 10], null),
            new PosMap(['line' => 15], null),
        ];
        $line = Line::loadFromPlainList($positions);
        $this->assertInstanceOf('axy\sourcemap\parsing\Line', $line);
        $expected = [
            10 => $positions[0],
            15 => $positions[1],
        ];
        $this->assertEquals($expected, $line->getPositions());
    }
}