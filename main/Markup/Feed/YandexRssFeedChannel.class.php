<?php


namespace Onphp;

class YandexRssFeedChannel extends FeedChannel
{
    private $logo;
    private $logoSquare;

    /**
     * @var string
     * Can be used for LiveInternet without params (counter name)
     */
    private $analytics;

    /** @var string named liveinternet counter */
    protected $liveInternetAnalytics;

    /**
     * @var string
     * News.Yandex supports multiple yandex.metrika codes
     * but this property for single code only
     **/
    protected $yandexAnalytics;

    /** @var string */
    protected $yandexAdNetworkId;

    /** @var array */
    protected $yandexAds = [];

    /** @var string */
    protected $googleAnalytics;

    /** @var string */
    protected $mailRuAnalytics;

    /** @var string */
    protected $ramblerAnalytics;

    /** @var string */
    protected $mediascopeAnalytics;

    protected $places = [
        0 => 'first_ad_place',
        1 => 'second_ad_place'
    ];

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoSquare()
    {
        return $this->logoSquare;
    }

    /**
     * @param string $logoSquare
     * @return $this
     */
    public function setLogoSquare($logoSquare)
    {
        $this->logoSquare = $logoSquare;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnalytics()
    {
        return $this->analytics;
    }

    /**
     * @param string $analytics
     * @return $this
     */
    public function setAnalytics($analytics)
    {
        $this->analytics = $analytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiveInternetAnalytics()
    {
        return $this->liveInternetAnalytics;
    }

    /**
     * @param string $liveInternetAnalytics
     * @return $this
     */
    public function setLiveInternetAnalytics($liveInternetAnalytics)
    {
        $this->liveInternetAnalytics = $liveInternetAnalytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYandexAnalytics()
    {
        return $this->yandexAnalytics;
    }

    /**
     * @param $yandexAnalytics
     * @return $this
     */
    public function setYandexAnalytics($yandexAnalytics)
    {
        $this->yandexAnalytics = $yandexAnalytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYandexAdNetworkId()
    {
        return $this->yandexAdNetworkId;
    }

    /**
     * @param string $yandexAdNetworkId
     * @return $this
     */
    public function setYandexAdNetworkId($yandexAdNetworkId)
    {
        $this->yandexAdNetworkId = $yandexAdNetworkId;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return YandexRssFeedChannel
     */
    public function addYandexAd($id)
    {
        $this->yandexAds[] = [
            'id' => $id,
            'type' => 'Yandex',
            'turbo-ad-id' => $this->places[count($this->yandexAds)],
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getYandexAds()
    {
        return $this->yandexAds;
    }

    /**
     * @return mixed
     */
    public function getGoogleAnalytics()
    {
        return $this->googleAnalytics;
    }

    /**
     * @param string $googleAnalytics
     * @return $this
     */
    public function setGoogleAnalytics($googleAnalytics)
    {
        $this->googleAnalytics = $googleAnalytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailRuAnalytics()
    {
        return $this->mailRuAnalytics;
    }

    /**
     * @param string $mailRuAnalytics
     * @return $this
     */
    public function setMailRuAnalytics($mailRuAnalytics)
    {
        $this->mailRuAnalytics = $mailRuAnalytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRamblerAnalytics()
    {
        return $this->ramblerAnalytics;
    }

    /**
     * @param string $ramblerAnalytics
     * @return $this
     */
    public function setRamblerAnalytics($ramblerAnalytics)
    {
        $this->ramblerAnalytics = $ramblerAnalytics;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMediascopeAnalytics()
    {
        return $this->mediascopeAnalytics;
    }

    /**
     * @param string $mediascopeAnalytics
     * @return $this
     */
    public function setMediascopeAnalytics($mediascopeAnalytics)
    {
        $this->mediascopeAnalytics = $mediascopeAnalytics;

        return $this;
    }
}
