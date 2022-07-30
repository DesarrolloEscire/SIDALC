<?php
/**
 * ISMN Test Class
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2019.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  Tests
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:testing:unit_tests Wiki
 */
use VuFindCode\ISMN;
require_once __DIR__ . '/../src/VuFindCode/ISMN.php';

/**
 * ISMN Test Class
 *
 * @category VuFind
 * @package  Tests
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:testing:unit_tests Wiki
 */
class ISMNTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that $raw results in valid $ismn10 and valid $ismn13.
     *
     * @dataProvider validISMN10
     * @return void
     */
    public function testValidISMN10($raw, $ismn10, $ismn13)
    {
        $ismn = new ISMN($raw);
        $this->assertEquals($ismn10, $ismn->get10());
        $this->assertEquals($ismn13, $ismn->get13());
        $this->assertTrue($ismn->isValid());
    }

    /**
     * Data provider for testValidISMN10().
     *
     * @return array
     */
    public function validISMN10() {
        return [
            'ISMN-10 plain'  => ['M230671187',        'M230671187', '9790230671187'],
            'ISMN-10 lower'  => ['m230671187',        'M230671187', '9790230671187'],
            'ISMN-10 spaces' => ['M 2306 7118 7',     'M230671187', '9790230671187'],
            'ISMN-10 dashes' => ['M-2306-7118-7',     'M230671187', '9790230671187'],
            'ISMN-10 dots'   => ['M.2306.7118.7',     'M230671187', '9790230671187'],
            'ISMN-10 _'      => ['M_2306_7118_7',     'M230671187', '9790230671187'],
            'ISMN-10 mixd'   => ['M_2306-7118.7',     'M230671187', '9790230671187'],
            'ISMN-13 plain'  => ['9790901679177',     'M901679177', '9790901679177'],
            'ISMN-13 dashes' => ['979-0-9016791-7-7', 'M901679177', '9790901679177'],
            'ISMN-13 spaces' => ['979 0 12345678 5',  'M123456785', '9790123456785'],
            'ISMN-13 dots'   => ['979.0.12345678.5',  'M123456785', '9790123456785'],
            'ISMN-13 _'      => ['979_0_12345678_5',  'M123456785', '9790123456785'],
            'ISMN-13 mixed'  => ['979_0.12345678-5',  'M123456785', '9790123456785'],
        ];
    }

    /**
     * Test Valid ISMN-13 that is not part of the music EAN range.
     *
     * @return void
     */
    public function testValidISMN13OutsideOfMusicEAN()
    {
        // Valid ISMN-13 outside of Bookland EAN:
        $ismn = new ISMN('9780123456786');
        $this->assertFalse($ismn->get10());
        $this->assertEquals('9780123456786', $ismn->get13());
        $this->assertTrue($ismn->isValid());
    }

    /**
     * Test Invalid ISMN.
     *
     * @dataProvider invalidISMN
     * @return void
     */
    public function testInvalidISMN($raw)
    {
        $ismn = new ISMN($raw);
        $this->assertFalse($ismn->get10());
        $this->assertFalse($ismn->get13());
        $this->assertFalse($ismn->isValid());
    }

    /**
     * Data provider for testInvalidISMN().
     *
     * @return array
     */
    public function invalidISMN() {
        return [
            'empty'                  => [''],
            'ISMN-10 wrong checksum' => ['2314346323'],
            'ISMN-13 wrong checksum' => ['9780123456787'],
            '10 times X'             => ['XXXXXXXXXX'],
            '13 times X'             => ['XXXXXXXXXXXXX'],
            'ISMN-10 with X inside'  => ['01234567X3'],
            'ISMN-13 with X inside'  => ['97901234567X9'],
            'UUID'                   => ['a9b7c8d0-a123-4567-abcdabcd86ef'],
        ];
    }

    /**
     * Test normalizeISMN($raw).
     *
     * @dataProvider normalizeISMN
     * @return void
     */
    public function testNormalizeISMN($raw, $ismn)
    {
        $this->assertEquals($ismn, ISMN::normalizeISMN($raw));
    }

    /**
     * Data provider for testNormalizeISMN().
     *
     * @return array
     */
    public function normalizeISMN() {
        return [
            ['', ''],
            ['1,22,333,4444,55555,666666,7777777', ''],
            ['1 22 333 4444 55555 666666 7777777', '1223334444555556666667777777'],
            ['123456789', '123456789'],
            ['123456789 , 87654321', '123456789'],
            ['1234567 , 123456789', '123456789'],
            [' -.1234567890123-. ', '1234567890123'],
            ['123 m123456789', 'M123456789'],
            ['1234567890123', '1234567890123'],
            ['12345678901k3', '12345678901'],
            ['1k34567890123', '34567890123'],
            ['1234567k890123', ''],
            ['ISMN10: M230671187, ISMN13: 9790230671187', 'M230671187'],
            ['ISMN13: 9790230671187, ISMN10: M230671187', '9790230671187'],
        ];
    }
}
