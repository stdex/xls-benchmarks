<?php
/**
* This file is part of the csv-benchmarks library
*
* @license http://opensource.org/licenses/MIT
* @link https://github.com/nyamsprod/csv-benchmark
* @version 0.1.0
* @package csv-benchmarks
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * Using PHP 5.5 generator to ease memory usage
 * @package csv-benchmarks
 * @since  0.1.0
 *
 * @param int $nb_rows
 *
 * @return array
 */
function generateRawData($nb_rows)
{
    for ($i = 0; $i < $nb_rows; $i++) {
        $index = $i;
        yield [
            'cell--'.($index),
            'cell--'.($index+1),
            'cell--'.($index+2),
        ];
    }
}
