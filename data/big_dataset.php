<?php

$types = array(
    'apple',
    'orange',
    'pear',
    'cherry',
    'type5',
    'type6',
    'type7',
    'type8',
    'type9',
    'type10',
);

$typeIds = array();

foreach ($types as $type) {
    dibi::insert('fruit_type', array('name' => $type))->execute();
    $typeIds[] = dibi::insertId();
}

foreach (range(0, 15000) as $num) {
    dibi::insert('fruit', array(
        'name' => 'fruit' . $num,
        'price' => (rand(50, 990) / 100),
        'fruit_type_id' => $typeIds[$num % 10],
    ))->execute();
}