<?php

namespace MattApril\ResponsableReports\Contracts;


use Symfony\Component\HttpFoundation\Response as SymphonyResponse;

interface ReportResponse {

    /**
     * @param array $data
     * @param string $title
     * @param array $headings
     *
     * @return SymphonyResponse
     */
    public function makeResponse(array $data, string $title, array $headings): SymphonyResponse;

    /**
     * @return string
     */
    public static function getMediaType(): string;

}