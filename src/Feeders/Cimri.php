<?php
namespace emreuyguc\ProductFeeder\Feeders;

use emreuyguc\ProductFeeder\Base\BaseFeeder;

class Cimri extends BaseFeeder
{
    public function makeFeed(): string
    {
        $json = [
            'url' => $this->feedData->site ?? '',
            'createDate' => $this->feedData->createDate,
            'products' => []
        ];

        foreach ($this->feedData->products as $product) {
            $json['products'][] = [
                'id' => $product->id,
                'name' => $product->title,
                'cost' => $product->price,
                'cat' => $product->category,
            ];
        }
        return json_encode($json);
    }

    public function getFileName(): string
    {
       return $this->feedData->createDate.'_cimri.json';
    }
}
