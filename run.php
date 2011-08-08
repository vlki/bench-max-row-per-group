<?php

define('DATA_DIR', __DIR__ . '/data');
define('SELECTS_DIR', __DIR__ . '/selects');
define('VENDOR_DIR', __DIR__ . '/vendor');

require_once VENDOR_DIR . '/dibi/dibi.min.php';

// Load selects
$selects = array();
require_once SELECTS_DIR . '/correlated_subquery.php';
require_once SELECTS_DIR . '/self_join.php';

// Load indexes
$indexes = array();
$indexes[] = false;
$indexes[] = 'ALTER TABLE `fruit` ADD INDEX `price` (`price`)';

dibi::connect(array(
    'driver' => 'pdo',
    'dsn' => 'mysql:host=localhost;dbname=',
    'username' => 'root',
    'password' => '',
));

// Initialize schema
dibi::query('DROP DATABASE IF EXISTS `bench-max-row-per-group`');
dibi::query('CREATE DATABASE `bench-max-row-per-group`');
dibi::query('USE `bench-max-row-per-group`');
dibi::loadFile(DATA_DIR . '/schema.sql');

// Small dataset
include DATA_DIR . '/small_dataset.php';

echo PHP_EOL;
echo '=== Small dataset ===' . PHP_EOL;

foreach ($indexes as $index) {
    if ($index !== false) {
        dibi::query($index);
    }

    foreach ($selects as $select) {
        $start = microtime(true);
        $result = call_user_func($select, dibi::getConnection());
        $duration = microtime(true) - $start;

        $indexText = '';
        if ($index !== false) {
            $indexText = ' (price index)';
        }

        echo "{$select}{$indexText}: {$duration} ms" . PHP_EOL;
    }
}

// Reinitialize schema
dibi::query('DROP DATABASE IF EXISTS `bench-max-row-per-group`');
dibi::query('CREATE DATABASE `bench-max-row-per-group`');
dibi::query('USE `bench-max-row-per-group`');
dibi::loadFile(DATA_DIR . '/schema.sql');

// Big dataset
include DATA_DIR . '/big_dataset.php';

echo PHP_EOL;
echo '=== Big dataset ===' . PHP_EOL;

foreach ($indexes as $index) {
    if ($index !== false) {
        dibi::query($index);
    }
    
    foreach ($selects as $select) {
        $start = microtime(true);
        $result = call_user_func($select, dibi::getConnection());
        $duration = microtime(true) - $start;

        $indexText = '';
        if ($index !== false) {
            $indexText = ' (price index)';
        }

        echo "{$select}{$indexText}: {$duration} ms" . PHP_EOL;
    }
}