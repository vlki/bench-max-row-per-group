<?php

/**
 * @param DibiConnection $dibiConn
 * @return array
 */
function correlatedSubquery($dibiConn)
{
    return $dibiConn->query('
        SELECT name, price, fruit_type_id
        FROM fruit
        WHERE price = (
          SELECT MIN(price)
          FROM fruit AS f
          WHERE f.fruit_type_id = fruit.fruit_type_id
        )
    ')->fetchAll();
}

$selects[] = 'correlatedSubquery';