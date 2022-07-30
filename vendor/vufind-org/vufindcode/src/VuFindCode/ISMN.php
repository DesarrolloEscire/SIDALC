<?php
/**
 * ISMN validation and conversion functionality
 *
 * PHP version 7
 *
 * Copyright (c) Demian Katz 2019.
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
 * ISMN Class
 *
 * This class provides ISMN validation and conversion functionality.
 *
 * @category VuFind
 * @package  Code
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Page
 */
class ISMN
{
    /**
     * Raw ISMN string
     *
     * @var string
     */
    protected $raw;

    /**
     * Validation status of ISMN (null until checked)
     *
     * @var bool
     */
    protected $valid = null;

    /**
     * Constructor
     *
     * @param string $raw Raw ISMN string to convert/validate.
     */
    public function __construct($raw)
    {
        // Strip out irrelevant characters:
        $this->raw = self::normalizeISMN($raw);
    }

    /**
     * Get the ISMN in ISMN-10 format:
     *
     * @return mixed ISMN, or false if invalid/incompatible.
     */
    public function get10()
    {
        // Is it valid?
        if ($this->isValid()) {
            // Is it already an ISMN-10?  If so, return as-is.
            if (strlen($this->raw) == 10) {
                return $this->raw;
            } elseif (strlen($this->raw) == 13
                && substr($this->raw, 0, 3) == '979'
            ) {
                // Is it a music EAN?  If so, we can convert to ISMN-10.
                $start = 'M' . substr($this->raw, 4, 8);
                return $start . self::getISMN10CheckDigit($start);
            }
        }

        // If we made it this far, conversion was not possible:
        return false;
    }

    /**
     * Get the ISMN in ISMN-13 format:
     *
     * @return mixed ISMN, or false if invalid/incompatible.
     */
    public function get13()
    {
        // Is it invalid?
        if (!$this->isValid()) {
            return false;
        }
        // Is it an ISMN-10?  If so, convert to music EAN:
        if (strlen($this->raw) == 10) {
            $start = '9790' . substr($this->raw, 1, 8);
            return $start . self::getISMN13CheckDigit($start);
        }
        // If we made it this far, it must already be an ISMN-13; return as-is.
        return $this->raw;
    }

    /**
     * Is the current ISMN valid in some format?  (May be 10 or 13 digit).
     *
     * @return bool
     */
    public function isValid()
    {
        // If we haven't already checked validity, do so now and store the result:
        if (null === $this->valid) {
            $this->valid = self::isValidISMN10($this->raw)
                || self::isValidISMN13($this->raw);
        }
        return $this->valid;
    }

    /**
     * Return the first sequence of at least 9 digits preceded by an optional M.
     * These ISMN characters may be separated by any number of '.', '-', '_' and
     * whitespace characters; the separation characters are removed.
     * A lower m is converted to an upper M.
     *
     * @param string $raw ISMN to clean up.
     *
     * @return string     Normalized ISMN.
     */
    public static function normalizeISMN($raw)
    {
        $regex = '/m?(?:(?:[\s_.-])*[0-9](?:[\s_.-])*){9,}/i';
        return preg_match($regex, $raw, $match)
            ? preg_replace('/[^0-9M]/', '', strtoupper($match[0])) : '';
    }

    /**
     * Given the first 9 digits of an ISMN-10, generate the check digit.
     *
     * @param string $ismn The first 9 digits of an ISMN-10.
     *
     * @return string      The check digit.
     */
    public static function getISMN10CheckDigit($ismn)
    {
        return static::getISMN13CheckDigit(preg_replace('/^m/i', '9790', $ismn));
    }

    /**
     * Is the provided ISMN-10 valid?
     *
     * @param string $ismn The ISMN-10 to test.
     *
     * @return bool
     */
    public static function isValidISMN10($ismn)
    {
        return static::isValidISMN13(preg_replace('/^m/i', '9790', $ismn));
    }

    /**
     * Given the first 12 digits of an ISMN-13, generate the check digit.
     *
     * @param string $ismn The first 12 digits of an ISMN-13.
     *
     * @return string      The check digit.
     */
    public static function getISMN13CheckDigit($ismn)
    {
        // ISMN-13 is the same as EAN-13:
        return EAN::getEAN13CheckDigit($ismn);
    }

    /**
     * Is the provided ISMN-13 valid?
     *
     * @param string $ismn The ISMN-13 to test.
     *
     * @return bool
     */
    public static function isValidISMN13($ismn)
    {
        // ISMN-13 is the same as EAN-13:
        return EAN::isValidEAN13($ismn);
    }
}
