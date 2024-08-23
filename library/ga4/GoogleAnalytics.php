<?php
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;

/**
 * A Common Google Analytic Utility  
 *  
 * @package YoGrowcer
 * @author Fatbit Team
 */
class GoogleAnalytics extends FatModel
{
    private BetaAnalyticsDataClient $client;
    private array $period;
    private array $metrics = [];
    private array $metricsString = [];
    private array $dimensions = [];
    private array $dimensionsString = [];
    private array $orderBy = [];
    private int $limit = 10;
    private int $offset = 0;
    private $response;

    function __construct(DateRange $period)
    {
        $this->client = new BetaAnalyticsDataClient(['credentials' => static::getClientJson()]);
        $this->period = [$period];
    }

    private static function getClientJson(): array
    {
        $authConfig = FatApp::getConfig('CONF_GOOGLE_ANALYTICS_CLIENT_JSON', FatUtility::VAR_STRING, '');
        $authConfig = json_decode($authConfig, true);
        if (!$authConfig || empty($authConfig)) {
            throw new Exception(Labels::getLabel('ERR_INVALID_GOOGLE_ANALYTICS_CLIENT_JSON.'));
        }
        return $authConfig;
    }

    private function get()
    {
        $propertyId = FatApp::getConfig('CONF_PROPERTY_ID', FatUtility::VAR_STRING, '');
        if (empty($propertyId)) {
            throw new Exception(Labels::getLabel('ERR_PLEASE_ADD_PROPERTY_ID.'));
        }

        // Make an API call.        
        try {
            $this->response = $this->client->runReport([
                'property' => "properties/$propertyId",
                'dateRanges' => $this->period,
                'metrics' => $this->metrics,
                'dimensions' => $this->dimensions,
                'limit' => $this->limit,
                'offset' => $this->offset,
                'orderBys' => $this->orderBy,
            ]);
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            $msg = !empty($msg) ? $msg : Labels::getLabel('LBL_SOMETTHING_WENT_WRONG_TRY_AGAIN');
            throw new Exception($msg);
        }
        return $this;
    }

    public function setLimit(int $maxResults = 10)
    {
        $this->limit = $maxResults;
    }

    public function setOffset(int $offset = 0)
    {
        $this->offset = $offset;
    }

    public function response()
    {
        return $this->response;
    }

    public function format()
    {
        if (empty($this->response)) {
            return false;
        }

        $result = [];
        foreach ($this->response->getRows() as $i => $row) {
            foreach ($row->getDimensionValues() as $j => $dimensionValue) {
                $result['dimensions'][$i][AnalyticsDimension::$dimensionNameArr[$j]] = $dimensionValue->getValue();
            }
            foreach ($row->getMetricValues() as $k => $metricValue) {
                $result['metrics'][$i][AnalyticsMetric::$metricNameArr[$k]] = $metricValue->getValue();
            }
        }
        return $result;
    }

    public function fetchVisitorsAndPageViews(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('activeUsers')->format(),
            AnalyticsMetric::set('screenPageViews')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('pageTitle')->format(),
        ];

        return $this->get();
    }

    public function fetchVisitorsAndPageViewsByDate(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('activeUsers')->format(),
            AnalyticsMetric::set('screenPageViews')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('pageTitle')->format(),
            AnalyticsDimension::set('date')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('date', true),
        ];

        return $this->get();
    }

    public function fetchTotalVisitorsAndPageViews(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('totalUsers')->format(),
            /* AnalyticsMetric::set('activeUsers')->format(),
            AnalyticsMetric::set('screenPageViews')->format(), */
        ];
        $this->dimensions = [
            AnalyticsDimension::set('date')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('date', true),
        ];

        return $this->get();
    }

    public function fetchMostVisitedPages(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('screenPageViews')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('pageTitle')->format(),
            AnalyticsDimension::set('fullPageUrl')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('screenPageViews', true),
        ];

        return $this->get();
    }

    public function fetchTopReferrers(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('screenPageViews')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('pageReferrer')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('screenPageViews', true),
        ];

        return $this->get();
    }

    public function fetchUserTypes(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('activeUsers')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('newVsReturning')->format(),
        ];

        return $this->get();
    }

    public function fetchTopBrowsers(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('screenPageViews')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('browser')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('screenPageViews', true),
        ];
        return $this->get();
    }

    public function getSocialVisits(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('totalUsers')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('googleAdsAdNetworkType')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('totalUsers', true),
        ];
        return $this->get();
    }
    
    public function getSearchTerm(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('activeUsers')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('searchTerm')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('activeUsers', true),
        ];
        return $this->get();
    }
   
    public function getTopCountries(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('totalUsers')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('country')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('totalUsers', true),
        ];
        return $this->get();
    }
   
    public function getTopReferrers(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('totalUsers')->format(),
        ];
        $this->dimensions = [
            AnalyticsDimension::set('source')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('totalUsers', true),
        ];
        return $this->get();
    }
    
    public function getTrafficSource(): self
    {
        $this->metrics = [
            AnalyticsMetric::set('totalUsers')->format(),
        ];
        $this->dimensions = [
            // AnalyticsDimension::set('sessionDefaultChannelGroup')->format(),
            AnalyticsDimension::set('defaultChannelGroup')->format(),
        ];
        $this->orderBy = [
            OrderBy::dimension('totalUsers', true),
        ];
        return $this->get();
    }
}
