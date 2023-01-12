# Product Feeder
Cimri, Google or Facebook wants products data from e-commerce systems for advertising or listing on their systems. E-commerce systems provide a file or feed through an API with all product data for each system in formats supported by the platforms (JSON, XML etc.).

## Features
- Raw Product to Product Model Data mapping
- Data manipulation during mapping (with callback)
- Memory optimization by using iterable during product mapping definition
- Common feed data model for data such as site data, version, date
- Using the feeders directly
- With the ProductFeeder class, multiple feeds can be output with a single FeedData definition
- default Feeders folder definition
- feeder file output format definition

## Usage
With cli
```sh
php cli.php out_dir=./outs/ feeder=all
```
Set Mapping and FeedProduct generator
```php
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
```

New FeedData and set products generator:
```php
$feedData = new FeedData();
$feedData
    /** Meta Data for some feeders **/
    ->setSite('www.mymerchant.com')
    ->setVersion('1.0')
    ->setCreateDate(date('d-m-Y'))
    ->setProducts($feedProducts);
```

With Single Feeder Instance:
```php
$feederInstance = new \emreuyguc\ProductFeeder\Feeders\Google($feedData);
header("Content-type: text/xml"); 
echo $feederInstance->makeFeed();
```

With Multiple Feeder and Output:
```php
$feeder = new ProductFeeder();
$feeder->setFeedData($feedData);

$feeder->makeAsFile(Feeder::CIMRI);
$feeder->makeAsFile(Feeder::GOOGLE);
```


## Notes
### FeedData Class

Dont forget products variable type is iterable
```php
public FeedProductMappingIterator $products;
```


### ProductFeeder Class
For Get available feeders. (dont forget remove file exts.)
```php
    ProductFeeder::getAvailableFeeders() : array;
```

Dont forget set feed data
```php
    $instance->setFeedData(FeedData $data):self;
```

For get data string
```php
    $instance->makeFeed(string $feeder_name):string;
```

For save as file
```php
    $instance->makeAsFile(string $feeder_name, string $out_path = './outputs/'): bool;
```

### Feeder Driver
Override this methods
```php
      public function makeFeed(): string;
      
      //return with extension
      public function getFileName(): string;
```

Handle feedData
```php
    public FeedData $feedData;
```




