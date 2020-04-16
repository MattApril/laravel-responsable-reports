<?php

namespace MattApril\ResponsableReports\Contracts;


use Illuminate\Contracts\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

interface PaginatedResponse {

    /**
     * @param Paginator $paginator
     * @param string $title
     * @param array $headings
     *
     * @return SymphonyResponse
     */
    public function makePaginatedResponse(Paginator $paginator, string $title, array $headings): SymphonyResponse;
}