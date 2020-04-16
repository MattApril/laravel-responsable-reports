<?php

namespace MattApril\ResponsableReports\Responses;

use Illuminate\Contracts\Pagination\Paginator;
use MattApril\ResponsableReports\Contracts\PaginatedResponse;
use Symfony\Component\HttpFoundation\Response as SymphonyResponse;


/**
 * Class JSON
 * This is an example implementation of a JSON response.
 *
 * @package MattApril\ResponsableReports\Responses
 */
class JSON extends Response implements PaginatedResponse
{
    /**
     * @var string
     */
    public const MEDIA_TYPE = 'application/json';

    /**
     * Generate a CSV response
     *
     * @param array $data
     * @param string $title
     * @param array $headings
     *
     * @return SymphonyResponse
     */
    public function makeResponse(array $data, string $title, array $headings): SymphonyResponse
    {
        return response()->json($data);
    }

    /**
     * @param Paginator $paginator
     * @param string $title
     * @param array $headings
     * @return SymphonyResponse
     */
    public function makePaginatedResponse(Paginator $paginator, string $title, array $headings): SymphonyResponse
    {
        return response()->json($paginator);
    }
}