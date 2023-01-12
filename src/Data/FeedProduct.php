<?php
namespace emreuyguc\ProductFeeder\Data;


class FeedProduct
{
    //todo Set const PROP_{your property} for easy mapping

    public int $id;
    public const PROP_ID = 'id';

    public string $title;
    public const PROP_TITLE = 'title';

    public float $price;
    public const PROP_PRICE = 'price';

    public ?string $stock = null;
    public const PROP_STOCK = 'stock';

    public string $category;
    public const PROP_CATEGORY = 'category';


    /**
     * @param array $raw_data
     * @param array $mappings
     * @return FeedProductMappingIterator<FeedProduct>
     */
    public static function generateProductData(
        array $raw_data,
        array $mappings
    ) : FeedProductMappingIterator{
        return new FeedProductMappingIterator($raw_data,$mappings);
    }


    /**
     * @param int $id
     * @return FeedProduct
     */
    public function setId(int $id): FeedProduct
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $title
     * @return FeedProduct
     */
    public function setTitle(string $title): FeedProduct
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param float $price
     * @return FeedProduct
     */
    public function setPrice(float $price): FeedProduct
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param string $stock
     * @return FeedProduct
     */
    public function setStock(string $stock): FeedProduct
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @param string $category
     * @return FeedProduct
     */
    public function setCategory(string $category): FeedProduct
    {
        $this->category = $category;
        return $this;
    }
}
