<?php

namespace MattApril\ResponsableReports\Responses;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use MattApril\ResponsableReports\Contracts\PaginatedReport;
use MattApril\ResponsableReports\Contracts\PaginatedResponse;
use MattApril\ResponsableReports\Contracts\Report;
use MattApril\ResponsableReports\Contracts\ReportResponse;

/**
 * Class Response
 * @package MattApril\ResponsableReports\Responses
 */
abstract class Response implements ReportResponse, Responsable
{
    /**
     * Defines the media type of this response
     * Used for content negotiation as well as the responses Content-Type header
     */
    public const MEDIA_TYPE = null;

    /**
     * @var Report
     */
    protected Report $report;

    /**
     * Response constructor.
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * @return string
     */
    public static function getMediaType(): string
    {
        return static::MEDIA_TYPE;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if($this->report instanceof PaginatedReport && $this instanceof PaginatedResponse) {
            $this->report->setPageNumber( $request->page ?? 1 ); // TODO 'page' should not be hardcoded
            $paginator = $this->report->getSinglePage();
            $response = $this->makePaginatedResponse($paginator, $this->report->getTitle(), $this->report->getHeadings());
        } else {
            $data = $this->report->getFullReport();
            $response = $this->makeResponse($data, $this->report->getTitle(), $this->report->getHeadings());
        }

        return $response;
    }
}