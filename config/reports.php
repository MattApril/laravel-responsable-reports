<?php
return [
    /**
     * Allowed report response types
     * Note: order is relevant for requests that accept all media types, as the first will be used.
     */
    'response_types' => [
        \MattApril\ResponsableReports\Responses\JSON::class,
        \MattApril\ResponsableReports\Responses\CSV::class
    ],
];