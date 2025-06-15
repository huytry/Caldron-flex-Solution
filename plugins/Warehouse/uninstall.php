<?php
$db = db_connect('default');
$dbprefix = get_db_prefix();

if ($db->tableExists($dbprefix . 'inventory_manage')) {
    $db->query('DROP TABLE `'.$dbprefix .'inventory_manage`;');
}

if ($db->tableExists($dbprefix . 'goods_receipt')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_receipt`;');
}

if ($db->tableExists($dbprefix . 'goods_receipt_detail')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_receipt_detail`;');
}

if ($db->tableExists($dbprefix . 'goods_delivery')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_delivery`;');
}

if ($db->tableExists($dbprefix . 'goods_delivery_detail')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_delivery_detail`;');
}

if ($db->tableExists($dbprefix . 'goods_delivery_invoices_pr_orders')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_delivery_invoices_pr_orders`;');
}

if ($db->tableExists($dbprefix . 'goods_transaction_detail')) {
    $db->query('DROP TABLE `'.$dbprefix .'goods_transaction_detail`;');
}

if ($db->tableExists($dbprefix . 'internal_delivery_note')) {
    $db->query('DROP TABLE `'.$dbprefix .'internal_delivery_note`;');
}

if ($db->tableExists($dbprefix . 'internal_delivery_note_detail')) {
    $db->query('DROP TABLE `'.$dbprefix .'internal_delivery_note_detail`;');
}

if ($db->tableExists($dbprefix . 'wh_loss_adjustment')) {
    $db->query('DROP TABLE `'.$dbprefix .'wh_loss_adjustment`;');
}

if ($db->tableExists($dbprefix . 'wh_loss_adjustment_detail')) {
    $db->query('DROP TABLE `'.$dbprefix .'wh_loss_adjustment_detail`;');
}

if ($db->tableExists($dbprefix . 'wh_approval_details')) {
    $db->query('DROP TABLE `'.$dbprefix .'wh_approval_details`;');
}

if ($db->tableExists($dbprefix . 'wh_activity_log')) {
    $db->query('DROP TABLE `'.$dbprefix .'wh_activity_log`;');
}


