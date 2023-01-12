<?php
namespace emreuyguc\ProductFeeder\Base;

use emreuyguc\ProductFeeder\Data\FeedData;

abstract class BaseFeeder implements IFeedActions
{
    public FeedData $feedData;

    public function __construct(FeedData $feedData)
    {
        $this->feedData = $feedData;
    }
}
