<?php
use Google\Analytics\Data\V1beta\DateRange;
class Period extends GoogleAnalytics
{
    private string $startDate;
    private string $endDate;

    private function __construct(string $startDate, string $endDate)
    {
        if (strtotime($startDate) > strtotime($endDate)) {
            $msg = Labels::getLabel('ERR_START_DATE_{SDATE}_CANNOT_BE_AFTER_END_DATE_{EDATE}.');
            $msg = CommonHelper::replaceStringData($msg, ['{SDATE}' => $startDate, '{EDATE}' => $endDate]);
            throw new Exception($msg);
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function format(): DateRange
    {
        return new DateRange(['start_date' => $this->startDate, 'end_date' => $this->endDate]);
    }

    public static function today(): static
    {
        return new static(date('Y-m-d'), date('Y-m-d'));
    }
    
    public static function days(int $numberOfDays): static
    {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', date(strtotime($endDate . '-' . $numberOfDays . ' days')));
        return new static($startDate, $endDate);
    }

    public static function months(int $numberOfMonths): static
    {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', date(strtotime($endDate . '-' . $numberOfMonths . ' Month')));
        return new static($startDate, $endDate);
    }

    public static function years(int $numberOfYears): static
    {
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', date(strtotime($endDate . '-' . $numberOfYears . ' Year')));
        return new static($startDate, $endDate);
    }
    
    public static function create(string $startDate, string $endDate): static
    {
        return new static($startDate, $endDate);
    }
}
