<?php

namespace Tests;


use Carbon\Carbon;
use MattApril\ResponsableReports\ReportGenerator;
use PHPUnit\Framework\TestCase;

class ReportGeneratorTest extends TestCase
{
    /**
     * Simple test of filter setter and getter methods
     */
    public function testSettingFilters() {
        $report = \Mockery::mock(ReportGenerator::class)->makePartial();
        $report->setFilters($filters = [
            'date' => Carbon::now(),
            'filter2' => true
        ]);
        $report->addFilters($addedFilters = [
            'filter3' => 100
        ]);

        $expectedFilters = array_merge($filters, $addedFilters);
        $this->assertEquals($expectedFilters, $report->getFilters());
    }

    /**
     * When a defaultTitle is defined on the class it should be returned as the report title
     */
    public function testDefaultTitle() {
        $report = \Mockery::mock(ReportGenerator::class)->makePartial();

        # TODO: any good reason this property is not public?
        $reflection = new \ReflectionClass($report);
        $reflectionProperty = $reflection->getProperty('defaultTitle');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($report, $title='My Default Title');

        $this->assertEquals($title, $report->getTitle());
    }

    /**
     * The instanceTitle method can be overridden on sub classes to allow
     * customization of the title for the current instance.
     */
    public function testInstanceTitle() {
        $report = \Mockery::mock(ReportGenerator::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $report->shouldReceive('instanceTitle')->andReturn($title=time());
        $this->assertEquals($title, $report->getTitle());
    }

    /**
     * When a class does not have a defaultTitle property, and/or instanceTitle method,
     * Then the class short-name will be used as a fallback report title
     */
    public function testNoTitleSpecified() {
        $report = \Mockery::mock(ReportGenerator::class)->makePartial();
        $reflection = new \ReflectionClass($report);
        $this->assertEquals($reflection->getShortName(), $report->getTitle());
    }
}