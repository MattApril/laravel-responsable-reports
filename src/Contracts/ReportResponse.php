<?php

namespace MattApril\ResponsableReports\Contracts;


interface ReportResponse {

    public function supportsPagination(): bool;

    public static function getMediaType(): string;
}