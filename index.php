<?php
/**
 *
 * @authors fisher (i@qnmlgb.trade)
 * @date    2019-02-13
 * @version 1.0
 */
define('ROOT',dirname(__FILE__));
require './config.php';
require 'lib/publicBackstage.class.php';
$pb = new publicBackstage($config);

$mod = isset($_GET['mod']) ? $_GET['mod'] : 'index';
$pb->urlRoute($mod);
