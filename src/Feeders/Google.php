<?php
namespace emreuyguc\ProductFeeder\Feeders;

use emreuyguc\ProductFeeder\Base\BaseFeeder;
use SimpleXMLElement;

class Google extends BaseFeeder
{
    public function makeFeed(): string{
        $doc = new SimpleXMLElement("<rss></rss>");;
        $doc->addAttribute('version', '2.0');

        $channel = $doc->addChild('channel');
        $link = $doc->addChild('link', $this->feedData->site ?? '');
        $title = $doc->addChild('title', $this->feedData->title ?? '');

        foreach ($this->feedData->products as $product) {
            $item = $channel->addChild('item');

            $item->addChild('g:id', $product->id);
            $item->addChild('title', $product->title);
            $item->addChild('g:price', $product->price);
            $item->addChild('g:category', $product->category);

        }
        return $doc->asXML();
    }


    public function getFileName(): string
    {
        return $this->feedData->createDate.'_google.xml';
    }
}
