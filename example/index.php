<?php
require_once '../vendor/autoload.php';

use emreuyguc\ProductFeeder\Data\FeedData;
use emreuyguc\ProductFeeder\Data\FeedProduct;
use emreuyguc\ProductFeeder\Feeders\Feeder;
use emreuyguc\ProductFeeder\ProductFeeder;

$raw_product_data = json_decode(file_get_contents('products.json'));

$feedProducts = FeedProduct::generateProductData(
    $raw_product_data,
    /** Mapping example  **/
    /** [PRODUCT MODEL PROP NAME] =>  [RAW DATA ARRAY KEY] **/
    [
        FeedProduct::PROP_ID => 'id',
        /** You can set callback on mapping variable   **/
        FeedProduct::PROP_TITLE => function ($row) {
            return mb_strtoupper($row['name']);
        },
        FeedProduct::PROP_PRICE => 'price',
        FeedProduct::PROP_CATEGORY => 'category'
    ]);

$feedData = new FeedData();
$feedData
    /** Meta Data for some feeders **/
    ->setSite('www.mymerchant.com')
    ->setVersion('1.0')
    ->setCreateDate(date('d-m-Y'))
    ->setProducts($feedProducts);

//ProductFeeder::getAvailableFeeders()
$feeder = new ProductFeeder();
$feeder->setFeedData($feedData);

header('Content-Type: application/json; charset=utf-8');
echo $feeder->makeFeed(Feeder::CIMRI);

/*
header("Content-type: text/xml");
echo $feeder->makeFeed(Feeder::GOOGLE);
*/