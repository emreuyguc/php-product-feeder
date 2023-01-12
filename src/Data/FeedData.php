<?php
namespace emreuyguc\ProductFeeder\Data;

use Generator;

class FeedData
{
    /**
     * @var iterable<FeedProduct> $products
     */
    public FeedProductMappingIterator $products;
    public string $site;
    public string $version;
    public string $createDate;
    public string $title;

    /**
     * @param FeedProductMappingIterator<FeedProduct> $products
     * @return FeedData
     */
    public function setProducts(FeedProductMappingIterator $products): FeedData
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param string $site
     * @return FeedData
     */
    public function setSite(string $site): FeedData
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @param string $version
     * @return FeedData
     */
    public function setVersion(string $version): FeedData
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param string $createDate
     * @return FeedData
     */
    public function setCreateDate(string $createDate): FeedData
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @param string $title
     * @return FeedData
     */
    public function setTitle(string $title): FeedData
    {
        $this->title = $title;
        return $this;
    }

}
