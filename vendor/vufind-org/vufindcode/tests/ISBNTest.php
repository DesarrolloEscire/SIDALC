<?php
/**
 * ISBN Test Class
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2010.
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
use VuFindCode\ISBN;
require_once __DIR__ . '/../src/VuFindCode/ISBN.php';

/**
 * ISBN Test Class
 *
 * @category VuFind
 * @package  Tests
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @author   Chris Hallberg <challber@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:testing:unit_tests Wiki
 */
class ISBNTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that $raw results in valid $isbn10 and valid $isbn13.
     *
     * @dataProvider validISBN10
     * @return void
     */
    public function testValidISBN10($raw, $isbn10, $isbn13)
    {
        $isbn = new ISBN($raw);
        $this->assertEquals($isbn10, $isbn->get10());
        $this->assertEquals($isbn13, $isbn->get13());
        $this->assertTrue($isbn->isValid());
    }

    /**
     * Data provider for testValidISBN10().
     *
     * @return array
     */
    public function validISBN10() {
        return [
            'ISBN-10 plain'  => ['0123456789',        '0123456789', '9780123456786'],
            'ISBN-10 dashes' => ['0-12-345678-9',     '0123456789', '9780123456786'],
            'ISBN-10 spaces' => ['0 12 345678 9',     '0123456789', '9780123456786'],
            'ISBN-10 dots'   => ['0.12.345678.9',     '0123456789', '9780123456786'],
            'ISBN-10 _'      => ['0_12_345678_9',     '0123456789', '9780123456786'],
            'ISBN-10 mixd'   => ['0_12-345678.9',     '0123456789', '9780123456786'],
            'ISBN-13 plain'  => ['9780123456786',     '0123456789', '9780123456786'],
            'ISBN-13 dashes' => ['978-0-12-345678-6', '0123456789', '9780123456786'],
            'ISBN-13 spaces' => ['978 0 12 345678 6', '0123456789', '9780123456786'],
            'ISBN-13 dots'   => ['978.0.12.345678.6', '0123456789', '9780123456786'],
            'ISBN-13 _'      => ['978_0_12_345678_6', '0123456789', '9780123456786'],
            'ISBN-13 mixed'  => ['978_0.12-345678 6', '0123456789', '9780123456786'],
            'ISBN-10 with x' => ['012345672x',        '012345672X', '9780123456724'],
            'ISBN-10 with X' => ['012345672X',        '012345672X', '9780123456724'],
        ];
    }

    /**
     * Test Valid ISBN-13 that is not part of the Bookland EAN.
     *
     * @return void
     */
    public function testValidISBN13OutsideOfBooklandEAN()
    {
        // Valid ISBN-13 outside of Bookland EAN:
        $isbn = new ISBN('9790123456785');
        $this->assertFalse($isbn->get10());
        $this->assertEquals('9790123456785', $isbn->get13());
        $this->assertTrue($isbn->isValid());
    }

    /**
     * Test Invalid ISBN.
     *
     * @dataProvider invalidISBN
     * @return void
     */
    public function testInvalidISBN($raw)
    {
        $isbn = new ISBN($raw);
        $this->assertFalse($isbn->get10());
        $this->assertFalse($isbn->get13());
        $this->assertFalse($isbn->isValid());
    }

    /**
     * Data provider for testInvalidISBN().
     *
     * @return array
     */
    public function invalidISBN() {
        return [
            'empty'                  => [''],
            'ISBN-10 wrong checksum' => ['2314346323'],
            'ISBN-13 wrong checksum' => ['9780123456787'],
            '10 times X'             => ['XXXXXXXXXX'],
            '13 times X'             => ['XXXXXXXXXXXXX'],
            'ISBN-10 with X inside'  => ['01234567X3'],
            'ISBN-13 with X inside'  => ['97901234567X9'],
            'UUID'                   => ['a9b7c8d0-a123-4567-abcdabcd86ef'],
        ];
    }

    /**
     * Test normalizeISBN($raw).
     *
     * @dataProvider normalizeISBN
     * @return void
     */
    public function testNormalizeISBN($raw, $isbn)
    {
        $this->assertEquals($isbn, ISBN::normalizeISBN($raw));
    }

    /**
     * Data provider for testNormalizeISBN().
     *
     * @return array
     */
    public function normalizeISBN() {
        return [
            ['', ''],
            ['1,22,333,4444,55555,666666,7777777', ''],
            ['1 22 333 4444 55555 666666 7777777', '1223334444555556666667777777'],
            ['12345678', '12345678'],
            ['12345678 , 87654321', '12345678'],
            ['1234567 , 12345678', '12345678'],
            ['ISBN 1-2-3-4-5-6-7-8-9-0 (book)', '1234567890'],
            ['ISBN 1.- .- 2.- .- 3.- .- 4.- .- 5.- .- 6.- .- 7.- .- 8.- .- 9.- .- 0 (book)', '1234567890'],
            [' -.1234567890123-. ', '1234567890123'],
            ['123456789-x 123', '123456789X'],
            ['123456789-x Xerography version',   '123456789X'],
            ['123456789-0 (Xerography version)', '1234567890'],
            ['123456789 Xerography version',     '123456789X'],  // space does not end ISBN
            ['123456789-0 Xerography version)',  '1234567890X'],
            ['1234567890123', '1234567890123'],
            ['12345678901k3', '12345678901'],
            ['1k34567890123', '34567890123'],
            ['1234567k890123', ''],
            ['ISBN10: 123456789x, ISBN13: 1234567890123', '123456789X'],
            ['ISBN13: 1234567890123, ISBN10: 123456789x', '1234567890123'],
        ];
    }
}
