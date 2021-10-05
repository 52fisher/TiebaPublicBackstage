<?php
/*
 * @Author: fisher(i@qnmlgb.trade)
 * @Date: 2021-06-20 19:47:23
 * @LastEditTime: 2021-10-06 03:26:29
 * @Description: 主页路由文件，请勿修改
 * @FilePath: /TiebaPublicBackstage/index.php
 * 
 * 
 */

define('ROOT',dirname(__FILE__));
require './config.php';
require 'lib/publicBackstage.class.php';
$pb = new publicBackstage($config);

$mod = isset($_GET['mod']) ? $_GET['mod'] : 'index';
$pb->urlRoute($mod);
