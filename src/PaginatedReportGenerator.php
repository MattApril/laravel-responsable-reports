<?php
declare(strict_types=1);

namespace MattApril\ResponsableReports;
use MattApril\ResponsableReports\Contracts\PaginatedReport;

/**
 * Class PaginatedReportGenerator
 * Base implementation of a paginated report.
 *
 * @author Matthew April
 */
abstract class PaginatedReportGenerator extends ReportGenerator implements PaginatedReport
{

    /**
     * @var int
     */
    protected $perPage = 25;

    /**
     * @var int
     */
    protected $pageNum = 1;

    /**
     * Sets number of records per page
     * @param int $perPage
     * @return void
     */
    public function setPerPage( int $perPage ): void {
        $this->perPage = $perPage;
    }

    /**
     * Sets page number to load
     * @param int $pageNum
     * @return void
     */
    public function setPageNumber( int $pageNum ): void {
        $this->pageNum = $pageNum;
    }

}