<?php

define('DATA_DIR', __DIR__ . '/data');
define('VENDOR_DIR', __DIR__ . '/vendor');

require_once VENDOR_DIR . '/dibi/dibi.min.php';

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

// TODO: for each data set execute every select