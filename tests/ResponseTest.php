<?php

namespace Tests;


use Illuminate\Pagination\LengthAwarePaginator;
use MattApril\ResponsableReports\PaginatedReportGenerator;
use MattApril\ResponsableReports\ReportGenerator;
use MattApril\ResponsableReports\Responses\JSON;
use MattApril\ResponsableReports\Responses\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * When a non-paginated report is converted to a response it should return the full report data
     */
    public function testNonPaginatedReport() {
        $reportData = [['col1' =>'data']];
        $report = \Mockery::mock(ReportGenerator::class)->makePartial();
        $report->shouldReceive('getFullReport')->once()->andReturn($reportData);

        $response = \Mockery::mock(Response::class.'[makeResponse]', [$report]);
        $response->shouldReceive('makeResponse')
            ->once()
            ->with($reportData, \Mockery::any(), \Mockery::any())
            ->andReturn($httpResponse = \Illuminate\Support\Facades\Response::make('Final Response'));
        $actualHttpResponse = $response->toResponse(new \stdClass());

        $this->assertSame($httpResponse, $actualHttpResponse);
    }

    /**
     * When a paginated report is converted into a response types that supports pagination
     * it should only return a single page.
     */
    public function testPaginatedReportWhenPaginationSupported() {
        $paginator = \Mockery::mock(LengthAwarePaginator::class);
        $report = \Mockery::mock(PaginatedReportGenerator::class)->makePartial();
        $report->shouldReceive('getSinglePage')->once()->andReturn($paginator);

        $response = \Mockery::mock(JSON::class.'[makePaginatedResponse]', [$report]);
        $response->shouldReceive('makePaginatedResponse')
            ->once()
            ->with($paginator, \Mockery::any(), \Mockery::any())
            ->andReturn($httpResponse = \Illuminate\Support\Facades\Response::make('Final Response'));
        $actualHttpResponse = $response->toResponse(new \stdClass());

        $this->assertSame($httpResponse, $actualHttpResponse);
    }

    /**
     * When a paginated report class is converted into a response that does not support pagination,
     * the full report should be requested from it.
     */
    public function testPaginatedReportWhenPaginationNotSupported() {
        $fullReportData = [['col1' =>'data']];
        $report = \Mockery::mock(PaginatedReportGenerator::class)->makePartial();
        $report->shouldReceive('getFullReport')->once()->andReturn($fullReportData);

        $response = \Mockery::mock(Response::class.'[makeResponse]', [$report]);
        $response->shouldReceive('makeResponse')
            ->once()
            ->with($fullReportData, \Mockery::any(), \Mockery::any())
            ->andReturn($httpResponse = \Illuminate\Support\Facades\Response::make('Final Response'));
        $actualHttpResponse = $response->toResponse(new \stdClass());

        $this->assertSame($httpResponse, $actualHttpResponse);
    }
}