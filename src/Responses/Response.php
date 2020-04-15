<?php

namespace MattApril\ResponsableReports\Responses;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use MattApril\ResponsableReports\Contracts\PaginatedReport;
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
     * False will never return paginated results
     * True will return paginated results for reports classes that support pagination.
     *
     * TODO: this is not really a property of the response type.. rethink.
     *
     * @var bool
     */
    protected $supportsPagination = false;

    /**
     * @var Report
     */
    protected $report;

    /**
     * Response constructor.
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * @return bool
     */
    public function supportsPagination(): bool
    {
        return $this->supportsPagination;
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
        if( $this->report instanceof PaginatedReport && $this->supportsPagination() ){
            $this->report->setPageNumber( $request->page ?? 1 ); // TODO 'page' should not be hardcoded
            $data = $this->report->getSinglePage();
        } else {
            $data = $this->report->getFullReport();
        }

        return $this->makeResponse($data, $this->report->getTitle(), $this->report->getHeadings());
    }

    /**
     * To be implemented by inheriting class.
     *
     * @param array $data
     * @param string $title
     * @param array $headings
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected abstract function makeResponse(array $data, string $title, array $headings): \Symfony\Component\HttpFoundation\Response;
}