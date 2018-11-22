<?php

namespace App\Weather;

use App\GoogleApi\WeatherService;
use App\Model\Weather;
use Symfony\Component\Cache\Simple\FilesystemCache;

class LoaderService
{
    /** @var WeatherService */
    private $weatherService;

    /** @var FilesystemCache */
    private $cacheService;

    /**
     * LoaderService constructor.
     * @param WeatherService  $weatherService
     * @param FilesystemCache $cacheService
     */
    public function __construct(WeatherService $weatherService, FilesystemCache $cacheService)
    {
        $this->weatherService = $weatherService;
        $this->cacheService = $cacheService;
    }

    /**
     * @param \DateTime $day
     * @return Weather
     * @throws \Exception
     */
    public function loadWeatherByDay(\DateTime $day): Weather
    {
        $cacheKey = $this->getCacheKey($day);

        if ($this->cacheService->has($cacheKey)) {
            echo 'from cache  ';
            $weather = $this->cacheService->get($cacheKey);
        } else {
            echo 'save to cache   ';
            $weather = $this->weatherService->getDay($day);
            $this->cacheService->set($cacheKey, $weather);
        }

        return $weather;
    }

    /**
     * @param \DateTime $day
     * @return string
     */
    private function getCacheKey(\DateTime $day): string
    {
        return $day->format('Y-m-d');
    }
}
