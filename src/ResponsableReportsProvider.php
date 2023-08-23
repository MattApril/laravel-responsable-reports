<?php

namespace MattApril\ResponsableReports;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use MattApril\ResponsableReports\Contracts\PaginatedReport;
use MattApril\ResponsableReports\Contracts\Report;
use MattApril\ResponsableReports\Contracts\ReportResponse;

class ResponsableReportsProvider extends ServiceProvider
{
    /**
     *
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../config/reports.php', 'reports');
    }

    /**
     *
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/../config/reports.php' => config_path('reports.php'),
        ]);

        # Register our 'report' response macro
        Response::macro('report', [$this, 'reportMacro']);
    }

    /**
     * @param Report $report
     * @return mixed
     */
    public function reportMacro(Report $report) {
        $responseClasses = collect(config('reports.response_types'));
        # key each response class by its media type
        $responseClasses = $responseClasses->keyBy(function($responseClass){
            if(is_a($responseClass, ReportResponse::class, true)){
                return $responseClass::getMediaType();
            } else {
                $expectedType = ReportResponse::class;
                throw new \RuntimeException("Class '$responseClass' defined in config reports.report_types must be instance of '{$expectedType}'");
            }
        });

        # set per page count from request
        $paginationConfig = config('reports.pagination');
        if($report instanceof PaginatedReport && isset($paginationConfig['per_page_key'])) {
            $perPage = app('request')->input($paginationConfig['per_page_key']);
            if(is_numeric($perPage)) {
                $perPage = (int) $perPage;
                # per page limit, if configured
                if(isset($paginationConfig['per_page_max'])) {
                    $perPage = min($perPage, (int) $paginationConfig['per_page_max']);
                }
                $perPage = max(1, $perPage); # at least 1
                $report->setPerPage($perPage);
            }
        }

        # choose media type via content negotiation
        $preferredMediaType = app('request')->prefers($responseClasses->keys()->toArray());


        # instantiate the response class with the given report instance
        $responseClass = $responseClasses->get($preferredMediaType, $responseClasses->first());
        return new $responseClass($report);
    }
}