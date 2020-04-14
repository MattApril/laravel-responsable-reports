<?php

namespace Tests;


use Illuminate\Support\Facades\Request;
use MattApril\ResponsableReports\Contracts\Report;
use MattApril\ResponsableReports\ResponsableReportsProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class ResponseMacroTest extends Orchestra
{
    /**
     * because no media type was specified by an Accept header, the first configured response class should be used.
     */
    public function testDefaultResponse() {
        $report = \Mockery::mock(Report::class);
        $reportResponse = response()->report($report);

        $expectedResponseClass = config('reports.response_types')[0];
        $this->assertInstanceOf($expectedResponseClass, $reportResponse);
    }

    /**
     * When a specific media type is requested via the Accept header,
     * our macro should return the response class that corresponds to that media type.
     */
    public function testNegotiatedResponse() {
        $expectedResponseClass = config('reports.response_types')[1];
        $requestedMediaType = $expectedResponseClass::getMediaType();

        # because we're not making a real application request,
        # lets mock the method we use on the request facade to define the preferred media type
        $request = Request::getFacadeRoot();
        $request = \Mockery::mock($request)->makePartial();
        $request->shouldReceive('prefers')->andReturn($requestedMediaType);
        Request::swap($request);

        $report = \Mockery::mock(Report::class);
        $reportResponse = response()->report($report);
        $this->assertInstanceOf($expectedResponseClass, $reportResponse);
    }

    /**
     * Register our package provider so that the response macro gets set.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app) {
        return [ResponsableReportsProvider::class];
    }
}