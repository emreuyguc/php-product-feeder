<?php
require_once '../vendor/autoload.php';

use emreuyguc\ProductFeeder\Data\FeedData;
use emreuyguc\ProductFeeder\Data\FeedProduct;
use emreuyguc\ProductFeeder\ProductFeeder;

$is_web=http_response_code()!==FALSE;

if ($is_web){
    die('only cli');
}

abstract class CliArgs{
    const feeder = 'feeder';
    const out_dir = 'out_dir';
    const product_file = 'product_file';
}

array_shift($argv);
$cli_args = [];
foreach ($argv as $arg){
    $param = explode('=',$arg);
    $key = $param[0];
    $value = $param[1];

    $cli_args[$key] = $value;
}


$raw_product_data = json_decode(file_get_contents($cli_args[CliArgs::product_file] ?? 'products.json'));

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

$feeder = new ProductFeeder();
$feeder->setFeedData($feedData);

if($cli_args[CliArgs::feeder] == 'all'){
    foreach(ProductFeeder::getAvailableFeeders() as $feeder_name){
        $feeder_name = explode('.',$feeder_name,2)[0];
        $feeder->makeAsFile($feeder_name,$cli_args[CliArgs::out_dir]);
    }
}
else{
    $req_feeders = explode(',',$cli_args[CliArgs::feeder]);
    foreach ($req_feeders as $feeder_name){
        $feeder->makeAsFile($feeder_name,$cli_args[CliArgs::out_dir]);
    }
}
