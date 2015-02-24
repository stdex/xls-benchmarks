<?php

/**
 * Using PHP 5.5 generator to ease memory usage
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
