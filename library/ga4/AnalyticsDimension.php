<?php
use Google\Analytics\Data\V1beta\Dimension;

class AnalyticsDimension extends GoogleAnalytics
{
    private string $dimensionName;
    public static array $dimensionNameArr;

    private function __construct(string $dimensionName)
    {
        if (empty($dimensionName)) {
            $link = '<a href="https://developers.google.com/analytics/devguides/reporting/data/v1/api-schema#dimensions">' . Labels::getLabel('LBL_DIMENSIONS') . '</a>';
            $msg = Labels::getLabel('ERR_INVALID_DIMENSION_{DIMENSION}._PLEASE_VISIT_{LINK}_TO_KNOW_MORE.');
            $msg = CommonHelper::replaceStringData($msg, ['{DIMENSION}' => $dimensionName, '{LINK}' => $link]);
            throw new Exception($msg);
        }
        $this->dimensionName = $dimensionName;
        self::$dimensionNameArr[] = $dimensionName;
    }

    public function format(): Dimension
    {
        return new Dimension(['name' => $this->dimensionName]);
    }

    public static function set(string $dimensionName): static
    {
        return new static($dimensionName);
    }
}
