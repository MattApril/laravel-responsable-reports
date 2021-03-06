<?php
declare(strict_types=1);

namespace MattApril\ResponsableReports\Contracts;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Interface Paginated
 * To be used in combination with Report contract to specify a paginated report interface.
 *
 * @author Matthew April
 */
interface PaginatedReport
{
    /**
     * gets a single paginated page
     * @return Paginator
     */
    public function getSinglePage(): Paginator;

    /**
     * Sets number of records per page
     * @param int $perPage
     */
    public function setPerPage( int $perPage ): void;

    /**
     * Sets page number to load
     * @param int $pageNum
     */
    public function setPageNumber( int $pageNum ): void;
}