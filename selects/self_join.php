<?php

/**
 * @param DibiConnection $dibiConn
 * @return array
 */
function selfJoin($dibiConn)
{
    return $dibiConn->query('
        SELECT f.name, f.price, f.fruit_type_id
        FROM (
          SELECT fruit_type_id, MIN(price) as minprice
          FROM fruit
          GROUP BY fruit_type_id
        ) AS x INNER JOIN fruit AS f ON f.fruit_type_id = x.fruit_type_id AND f.price = x.minprice
    ')->fetchAll();
}

$selects[] = 'selfJoin';