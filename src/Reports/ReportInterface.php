<?php

namespace AuphanPHP\Reports;

interface ReportInterface
{
    public function getReportEndpoint(): string;

    public function getReportParameters(): array;
}