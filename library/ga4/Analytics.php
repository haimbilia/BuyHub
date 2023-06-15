<?php
class Analytics
{
    private array $result = [];
    private function format($response)
    {
        $this->result = [
            'totalsForAllResults' => 0,
            'rows' => []
        ];

        foreach ($response->getRows() as $row) {
            $metrics = $row->getMetricValues();
            foreach ($row->getDimensionValues() as $i => $dimensionValue) {
                $dimValue = $dimensionValue->getValue();
                $metricsVal = $metrics[$i]->getValue();
                $this->result['totalsForAllResults'] += $metricsVal;
                $this->result['rows'][$dimValue] = [
                    'visit' => $metricsVal
                ];
            }
        }

        $totalVisits = $this->result['totalsForAllResults'];
        foreach ($this->result['rows'] as &$visits) {
            $visits['%age'] = ($totalVisits > 0) ? round(($visits['visit'] * 100) / $totalVisits, 2) : 0;
        }
        return $this->result;
    }

    public function getVisitsByDate(): array
    {
        $interval = [
            'today' => [
                'period' => Period::today(),
                'limit' => 1
            ],
            'weekly' => [
                'period' => Period::days(7),
                'limit' => 7
            ],
            'lastMonth' => [
                'period' => Period::months(1),
                'limit' => 31
            ],
            'last3Month' => [
                'period' => Period::months(3),
                'limit' => 92
            ],
        ];

        $result = [];
        foreach ($interval as $intervalKey => $attr) {
            $obj = new GoogleAnalytics($attr['period']->format());
            $obj->setLimit($attr['limit']);
            $response = $obj->fetchTotalVisitorsAndPageViews()->response();
            $result['result'][$intervalKey]['totalsForAllResults'] = 0;
            foreach ($response->getRows() as $i => $row) {
                $metrics = $row->getMetricValues();
                foreach ($row->getDimensionValues() as $j => $dimensionValue) {
                    $dimValue = $dimensionValue->getValue();
                    $metricsVal = $metrics[$j]->getValue();
                    $result['result'][$intervalKey]['totalsForAllResults'] += $metricsVal;
                    $result['result'][$intervalKey]['rows'][$dimValue] = [
                        'visit' => $metricsVal
                    ];
                }
            }
            $totalVisits = $result['result'][$intervalKey]['totalsForAllResults'];
            $result['result'][$intervalKey]['rows'] = $result['result'][$intervalKey]['rows'] ?? [];
            foreach ($result['result'][$intervalKey]['rows'] as $date => &$visits) {
                $visits['%age'] = ($totalVisits > 0) ? round(($visits['visit'] * 100) / $totalVisits, 2) : 0;
                $result['stats'][$date][$intervalKey] = [
                    'visit' => $visits['visit'],
                    '%age' => $visits['%age']
                ];
            }
        }
        return $result;
    }

    public function getSocialVisits(): array
    {
        $obj = new GoogleAnalytics(Period::years(1)->format());
        return $this->format($obj->getSocialVisits()->response());
    }

    public function getTopCountries(string $type = 'TODAY', int $limit = 10): array
    {
        $period = Period::today();
        switch (strtoupper($type)) {
            case 'WEEKLY':
                $period = Period::days(7);
                break;
            case 'MONTHLY':
                $period = Period::months(1);
                break;
            case 'YEARLY':
                $period = Period::years(1);
                break;
        }

        $obj = new GoogleAnalytics($period->format());
        $obj->setLimit($limit);
        return $this->format($obj->getTopCountries()->response());
    }

    public function getTopReferrers(string $type = 'TODAY', int $limit = 10): array
    {
        $period = Period::today();
        switch (strtoupper($type)) {
            case 'WEEKLY':
                $period = Period::days(7);
                break;
            case 'MONTHLY':
                $period = Period::months(1);
                break;
            case 'YEARLY':
                $period = Period::years(1);
                break;
        }

        $obj = new GoogleAnalytics($period->format());
        $obj->setLimit($limit);
        return $this->format($obj->getTopReferrers()->response());
    }

    public function getTrafficSource(string $type = 'TODAY', int $limit = 10): array
    {
        $period = Period::today();
        switch (strtoupper($type)) {
            case 'WEEKLY':
                $period = Period::days(7);
                break;
            case 'MONTHLY':
                $period = Period::months(1);
                break;
            case 'YEARLY':
                $period = Period::years(1);
                break;
        }

        $obj = new GoogleAnalytics($period->format());
        $obj->setLimit($limit);
        return $this->format($obj->getTrafficSource()->response());
    }
}
