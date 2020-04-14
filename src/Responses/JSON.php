<?php

namespace MattApril\ResponsableReports\Responses;

use Symfony\Component\HttpFoundation\Response as SymphonyResponse;


/**
 * Class JSON
 * This is an example implementation of a JSON response.
 *
 * @package MattApril\ResponsableReports\Responses
 */
class JSON extends Response
{
    /**
     * @var string
     */
    public const MEDIA_TYPE = 'application/json';

    /**
     * @var bool
     */
    protected $supportsPagination = true;

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
}