<?php

use Page\VideoListPage as VideoListPage;

class VideoPreviewTestCest
{

    public function checkPreviewVideoIsVisible(AcceptanceTester $I, VideoListPage $videoListPage)
    {
        $I->amOnPage($videoListPage::$URL);
        $videoListPage
            ->inputSearchField("Ураган")
            ->clickSearchButton()
            ->waitForDownloadOfVideoListIsOver()
            ->mouseOverToVideoByNumber(1)
            ->checkPreviewVideoIsVisible()
            ->checkCurrentTimeAtRandomTimePreviewVideo()
            ->checkCurrentTimeAfterEndOfPreviewVideo();
    }
}
