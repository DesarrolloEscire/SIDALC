<?php
/**
 * EAN validation and checksumming functionality
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
 * EAN Class
 *
 * This class provides EAN validation and checksumming functionality.
 *
 * @category VuFind
 * @package  Code
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Page
 */
class EAN
{
    /**
     * Return the first sequence of at least 12 digits followed by an optional X.
     * These characters may be separated by any number of '.', '-', '_' and
     * whitespace characters; the separation characters are removed.
     * A lower x is converted to an upper X.
     *
     * @param string $raw EAN to clean up.
     *
     * @return string     Normalized EAN.
     */
    public static function normalizeEAN($raw)
    {
        if (!preg_match('/(?:\d(?:[\s_.-])*){12,}[xX]?/', $raw, $match)) {
            return '';
        }
        return preg_replace('/[^0-9X]/', '', strtoupper($match[0]));
    }

    /**
     * Given the first 12 digits of an EAN, generate the check digit.
     *
     * @param string $ean The first 12 digits of an EAN.
     *
     * @return string     The check digit.
     */
    public static function getEAN13CheckDigit($ean)
    {
        $sum = 0;
        $weight = 1;
        for ($x = 0; $x < strlen($ean); $x++) {
            $sum += intval(substr($ean, $x, 1)) * $weight;
            $weight = $weight == 1 ? 3 : 1;
        }
        $retval = 10 - ($sum % 10);
        return $retval == 10 ? 0 : $retval;
    }

    /**
     * Is the provided EAN valid?
     *
     * @param string $ean The EAN to test.
     *
     * @return bool
     */
    public static function isValidEAN13($ean)
    {
        $ean = static::normalizeEAN($ean);
        if (strlen($ean) != 13) {
            return false;
        }
        return
            substr($ean, 12) == self::getEAN13CheckDigit(substr($ean, 0, 12));
    }
}
