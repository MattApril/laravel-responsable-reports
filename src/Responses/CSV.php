<?php

namespace MattApril\ResponsableReports\Responses;

use Symfony\Component\HttpFoundation\Response as SymphonyResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class CSV
 * This is an example implementation of a CSV response.
 *
 * @package MattApril\ResponsableReports\Responses
 */
class CSV extends Response
{
    /**
     * @var string
     */
    public const MEDIA_TYPE = 'text/csv';

    /**
     * @var bool
     */
    protected $supportsPagination = false;

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
        # insert headings as first row
        array_unshift($data, $headings);

        $now = gmdate('D,d M Y H:i:s') . ' GMT';
        return new StreamedResponse(
            function() use ($data) {
                // A resource pointer to the output stream for writing the CSV to
                $handle = fopen('php://output', 'w');
                // Loop through the data and write each entry as a new row in the csv
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            },
            200,
            [
                'Content-Type'          => self::MEDIA_TYPE,
                'Content-Disposition'   => "attachment; filename=\"{$title}.csv\"",
                'Pragma'                => 'no-cache',
                'Cache-Control'         => 'no-cache, must-revalidate',
                'Last-Modified'         => $now,
                'Expires'               => $now,
            ]
        );
    }
}