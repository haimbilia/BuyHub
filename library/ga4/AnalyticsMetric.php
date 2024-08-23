<?php
use Google\Analytics\Data\V1beta\Metric;

class AnalyticsMetric extends GoogleAnalytics
{
    private string $metricName;
    public static array $metricNameArr;

    private function __construct(string $metricName)
    {
        if (empty($metricName)) {
            $link = '<a href="https://developers.google.com/analytics/devguides/reporting/data/v1/api-schema#metrics">' . Labels::getLabel('LBL_DIMENSIONS') . '</a>';
            $msg = Labels::getLabel('ERR_INVALID_METRIC_{METRIC}._PLEASE_VISIT_{LINK}_TO_KNOW_MORE.');
            $msg = CommonHelper::replaceStringData($msg, ['{METRIC}' => $metricName, '{LINK}' => $link]);
            throw new Exception($msg);
        }
        $this->metricName = $metricName;
        self::$metricNameArr[] = $metricName;
    }

    public function format(): Metric
    {
        return new Metric(['name' => $this->metricName]);
    }

    public static function set(string $metricName): static
    {
        return new static($metricName);
    }
}
