<?php

namespace emreuyguc\ProductFeeder\Data;

use Generator;

class FeedProductMappingIterator implements \IteratorAggregate{
    private array $_raw_data;
    private array $_mappings;

    /**
     * @param array $raw_data
     * @param array $mappings
     */
    public function __construct(array &$raw_data, array &$mappings)
    {
        $this->_raw_data = $raw_data;
        $this->_mappings = $mappings;
    }

    public function getIterator(): Generator{
        foreach ($this->_raw_data as $row) {
            if($row instanceof \stdClass){
                $row = (array) $row;
            }

            $feedProduct = new FeedProduct();

            foreach ($this->_mappings as $product_model_prop => $data_handler) {
                $prop_setter = 'set' . ucfirst($product_model_prop);
                $mapped_value = is_callable($data_handler)
                    ? $data_handler($row)
                    : @$row[$data_handler];

                if(method_exists($feedProduct,$prop_setter) && $mapped_value){
                    $feedProduct->{$prop_setter}($mapped_value);
                }
            }
            yield $feedProduct;
        }
    }
}