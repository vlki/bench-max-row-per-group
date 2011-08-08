<?php

$types = array(
    'apple',
    'orange',
    'pear',
    'cherry',
);

$typeIds = array();

foreach ($types as $type) {
    dibi::insert('fruit_type', array('name' => $type))->execute();
    $typeIds[$type] = dibi::insertId();
}

$fruits = array(
    array('name' => 'gala', 'price' => '2.79', 'fruit_type_id' => $typeIds['apple']),
    array('name' => 'fuji', 'price' => '0.24', 'fruit_type_id' => $typeIds['apple']),
    array('name' => 'limbertwig', 'price' => '2.87', 'fruit_type_id' => $typeIds['apple']),
    array('name' => 'valencia', 'price' => '3.59', 'fruit_type_id' => $typeIds['orange']),
    array('name' => 'navel', 'price' => '9.36', 'fruit_type_id' => $typeIds['orange']),
    array('name' => 'bradford', 'price' => '6.05', 'fruit_type_id' => $typeIds['pear']),
    array('name' => 'bartlett', 'price' => '2.14', 'fruit_type_id' => $typeIds['pear']),
    array('name' => 'bing', 'price' => '2.55', 'fruit_type_id' => $typeIds['cherry']),
    array('name' => 'chelan', 'price' => '6.33', 'fruit_type_id' => $typeIds['cherry']),
);

foreach ($fruits as $fruit) {
    dibi::insert('fruit', $fruit)->execute();
}