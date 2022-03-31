<?php

namespace Page;

use Codeception\Util\Locator;

class VideoListPage
{
    public static $URL = '/video';

    private $I;
    private static $searchField = '.mini-suggest__input';
    private static $searchButton = 'button[class*="mini-suggest__button"]';
    private static $spinnerElement = '.spin2_js_inited.spin2_progress_yes.spin2_size_m';
    private static $videoElements = '.serp-item_type_search';
    private static $previewVideoElement = '.thumb-preview__target_playing';

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
}
