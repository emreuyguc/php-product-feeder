<?php

namespace emreuyguc\ProductFeeder;

use emreuyguc\ProductFeeder\Base\BaseFeeder;
use emreuyguc\ProductFeeder\Data\FeedData;
use ErrorException;

class ProductFeeder
{
    private ?FeedData $_feedData = null;

    private static $_defaultFeedersDir = __DIR__ . '/Feeders/';

    public static function getAvailableFeeders(): array
    {
        return array_filter(array_diff(scandir(self::$_defaultFeedersDir), array('..', '.')),
            function($e) {
            return $e != 'Feeder.php';
        });
    }

    public function setDefaultFeedersDir(string $defaultFeedersDir): void
    {
        self::$_defaultFeedersDir = $defaultFeedersDir;
    }

    public function setFeedData(FeedData $feedData): ProductFeeder
    {
        $this->_feedData = $feedData;
        return $this;
    }

    public function makeFeed(string $feeder): string
    {
        if (!$this->_feedData) throw new ErrorException('Feed data must be required');
        return $this->_getFeederInstance($feeder)->makeFeed();
    }

    public function makeAsFile(string $feeder, string $out_path = './outputs/'): bool
    {
        if (!is_dir($out_path)) {
            mkdir($out_path, 0755);
        }
        $feederInstance = $this->_getFeederInstance($feeder);
        return file_put_contents($out_path . $feederInstance->getFileName(), $feederInstance->makeFeed());
    }

    private function _getFeederInstance(string $feeder): BaseFeeder
    {
        if (!file_exists(self::$_defaultFeedersDir . $feeder . '.php')) {
            throw new ErrorException('Feeder not exist !  feeder : ' . $feeder);
        }

        $feeder_ns = 'emreuyguc\\ProductFeeder\\Feeders\\' . $feeder;

        /** @var BaseFeeder $feeder */
        return new $feeder_ns($this->_feedData);
    }
}