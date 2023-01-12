<?php
namespace emreuyguc\ProductFeeder\Base;

use emreuyguc\ProductFeeder\Data\FeedData;

interface IFeedActions
{
    public function makeFeed(): string;

    //todo  maybe moved to a class like FeedOutput --> data , filename, extension .....
    public function getFileName(): string;

    public function __construct(FeedData $feedData);
}
