<?php

namespace AuphanPHP\Integration;

use AuphanPHP\Client;
use AuphanPHP\Tests\Integration\Reports\DailySalesReport;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function test_it_can_retrieve_report_data()
    {
        $report = $this->getClient()->report(new DailySalesReport);
        $dates = $report->map(fn ($array) => $array[2]);

        $this->assertGreaterThan(0, $report->count());
        $this->assertContains('Jan 01, 2022', $dates);
        $this->assertContains('Jan 02, 2022', $dates);
        $this->assertContains('Jan 03, 2022', $dates);
    }

    private function getClient(): Client
    {
        return (new Client)
            ->setApiToken(getenv('AUPHAN_API_TOKEN'))
            ->setBaseUri(getenv('AUPHAN_BASE_URI'));
    }
}