<?php
/**
 * ISBN validation and conversion functionality
 *
 * PHP version 7
 *
 * Copyright (c) Demian Katz 2010.
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
 * @package  Code
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Page
 */
namespace VuFindCode;

/**
 * ISBN Class
 *
 * This class provides ISBN validation and conversion functionality.
 *
 * @category VuFind
 * @package  Code
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Page
 */
class ISBN
{
    /**
     * Raw ISBN string
     *
     * @var string
     */
    protected $raw;

    /**
     * Validation status of ISBN (null until checked)
     *
     * @var bool
     */
    protected $valid = null;

    /**
     * Constructor
     *
     * @param string $raw Raw ISBN string to convert/validate.
     */
    public function __construct($raw)
    {
        // Strip out irrelevant characters:
        $this->raw = self::normalizeISBN($raw);
    }

    /**
     * Get the ISBN in ISBN-10 format:
     *
     * @return mixed ISBN, or false if invalid/incompatible.
     */
    public function get10()
    {
        // Is it valid?
        if ($this->isValid()) {
            // Is it already an ISBN-10?  If so, return as-is.
            if (strlen($this->raw) == 10) {
                return $this->raw;
            } elseif (strlen($this->raw) == 13
                && substr($this->raw, 0, 3) == '978'
            ) {
                // Is it a Bookland EAN?  If so, we can convert to ISBN-10.
                $start = substr($this->raw, 3, 9);
                return $start . self::getISBN10CheckDigit($start);
            }
        }

        // If we made it this far, conversion was not possible:
        return false;
    }

    /**
     * Get the ISBN in ISBN-13 format:
     *
     * @return mixed ISBN, or false if invalid/incompatible.
     */
    public function get13()
    {
        // Is it invalid?
        if (!$this->isValid()) {
            return false;
        }
        // Is it an ISBN-10?  If so, convert to Bookland EAN:
        if (strlen($this->raw) == 10) {
            $start = '978' . substr($this->raw, 0, 9);
            return $start . self::getISBN13CheckDigit($start);
        }
        // If we made it this far, it must already be an ISBN-13; return as-is.
        return $this->raw;
    }

    /**
     * Is the current ISBN valid in some format?  (May be 10 or 13 digit).
     *
     * @return bool
     */
    public function isValid()
    {
        // If we haven't already checked validity, do so now and store the result:
        if (null === $this->valid) {
            $this->valid = self::isValidISBN10($this->raw)
                || self::isValidISBN13($this->raw);
        }
        return $this->valid;
    }

    /**
     * Return the first sequence of at least 8 digits followed by an optional X.
     * These ISBN characters may be separated by any number of '.', '-', '_' and
     * whitespace characters; the separation characters are removed.
     * A lower x is converted to an upper X.
     *
     * @param string $raw ISBN to clean up.
     *
     * @return string     Normalized ISBN.
     */
    public static function normalizeISBN($raw)
    {
        if (!preg_match('/(?:\d(?:[\s_.-])*){8,}[xX]?/', $raw, $match)) {
            return '';
        }
        return preg_replace('/[^0-9X]/', '', strtoupper($match[0]));
    }

    /**
     * Given the first 9 digits of an ISBN-10, generate the check digit.
     *
     * @param string $isbn The first 9 digits of an ISBN-10.
     *
     * @return string      The check digit.
     */
    public static function getISBN10CheckDigit($isbn)
    {
        $sum = 0;
        for ($x = 0; $x < strlen($isbn); $x++) {
            $sum += intval(substr($isbn, $x, 1)) * (1 + $x);
        }
        $checkdigit = $sum % 11;
        return $checkdigit == 10 ? 'X' : $checkdigit;
    }

    /**
     * Is the provided ISBN-10 valid?
     *
     * @param string $isbn The ISBN-10 to test.
     *
     * @return bool
     */
    public static function isValidISBN10($isbn)
    {
        $isbn = self::normalizeISBN($isbn);
        if (strlen($isbn) != 10) {
            return false;
        }
        return substr($isbn, 9) == self::getISBN10CheckDigit(substr($isbn, 0, 9));
    }

    /**
     * Given the first 12 digits of an ISBN-13, generate the check digit.
     *
     * @param string $isbn The first 12 digits of an ISBN-13.
     *
     * @return string      The check digit.
     */
    public static function getISBN13CheckDigit($isbn)
    {
        // ISBN-13 is the same as EAN-13:
        return EAN::getEAN13CheckDigit($isbn);
    }

    /**
     * Is the provided ISBN-13 valid?
     *
     * @param string $isbn The ISBN-13 to test.
     *
     * @return bool
     */
    public static function isValidISBN13($isbn)
    {
        // ISBN-13 is the same as EAN-13:
        return EAN::isValidEAN13($isbn);
    }
}
