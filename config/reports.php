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

    /**
     * Pagination settings
     */
    'pagination' => [
        # request input key used to dynamically set the results per page
        # leave unset to prevent this or implement your own.
        'per_page_key' => env('REPORT_PER_PAGE_KEY'),

        # max results per page using per_page_key
        'per_page_max' => env('REPORT_PER_PAGE_MAX', 100)
    ]
];