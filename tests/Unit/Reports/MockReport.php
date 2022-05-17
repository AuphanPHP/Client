<?php

namespace AuphanPHP\Tests\Unit\Reports;

use AuphanPHP\Reports\ReportInterface;

class MockReport implements ReportInterface
{
    public function getReportEndpoint(): string
    {
        return 'reports/api.php/';
    }

    public function getReportParameters(): array
    {
        return [
            'test-key' => 'test-value',
        ];
    }
}