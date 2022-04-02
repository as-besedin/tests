<?php

namespace Page;

use Codeception\Util\Locator;
use PHPUnit\Framework\Assert;

class VideoListPage
{
    public static $URL = '/video';

    private $I;
    private static $searchField = '.mini-suggest__input';
    private static $searchButton = 'button[class*="mini-suggest__button"]';
    private static $spinnerElement = '.spin2_js_inited.spin2_progress_yes.spin2_size_m';
    private static $videoElements = '.serp-item_type_search';
    private static $previewVideoElement = 'video';

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    public function inputSearchField($searchText): VideoListPage
    {
        $this->I->fillField(self::$searchField, $searchText);
        return $this;
    }

    public function clickSearchButton(): VideoListPage
    {
        $this->I->click(self::$searchButton);
        return $this;
    }

    public function waitForDownloadOfVideoListIsOver(): VideoListPage
    {
        $this->I->waitForElementVisible(self::$spinnerElement);
        $this->I->waitForElementNotVisible(self::$spinnerElement);
        return $this;
    }

    public function mouseOverToVideoByNumber($number): VideoListPage
    {
        $this->I->moveMouseOver(Locator::elementAt(self::$videoElements, $number));
        return $this;
    }

    public function checkPreviewVideoIsVisible(): VideoListPage
    {
        $this->I->waitForElementVisible(self::$previewVideoElement);
        $this->I->seeElement(self::$previewVideoElement);
        return $this;
    }

    public function checkCurrentTimeAtRandomTimePreviewVideo(): VideoListPage
    {
        $duration = self::getPreviewVideoDuration();
        $randomTime = rand(0, $duration);
        sleep($randomTime);
        $currentTime = self::getPreviewVideoCurrentTime();

        Assert::assertEquals($randomTime, $currentTime);
        return $this;
    }

    public function checkCurrentTimeAfterEndOfPreviewVideo(): VideoListPage
    {
        $duration = self::getPreviewVideoDuration();
        sleep($duration);
        $currentTime = self::getPreviewVideoCurrentTime();

        Assert::assertEquals(0, $currentTime);
        return $this;
    }

    private function getPreviewVideoDuration(): int {
        return $this->I->executeJS('return document.querySelector(arguments[0]).duration', [self::$previewVideoElement]);
    }

    private function getPreviewVideoCurrentTime(): int {
        return $this->I->executeJS('return document.querySelector(arguments[0]).currentTime', [self::$previewVideoElement]);
    }
}
