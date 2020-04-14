<?php
declare(strict_types=1);

namespace MattApril\ResponsableReports;
use MattApril\ResponsableReports\Contracts\Report;

/**
 * Class ReportGenerator
 * Base implementation of a report generation class.
 * Role is to simply generate a data set with any given filters.
 *
 * @author Matthew April
 */
abstract class ReportGenerator implements Report
{
    /**
     * default report title, will be used as is if no
     * @var string
     */
    protected $defaultTitle;

    /**
     * Headings as they should appear on export
     * @var array
     */
    protected $headings = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Sets all filters
     * @param array $filters
     * @return mixed
     */
    public function setFilters( array $filters ): void {
        $this->filters = $filters;
    }

    /**
     * Apply additional filters
     * @param array $filters
     * @return mixed
     */
    public function addFilters( array $filters ): void {
        $this->filters = array_merge( $this->filters, $filters );
    }

    /**
     * @return array
     */
    public function getFilters(): array {
        return $this->filters;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        # if no title is defined we will fall back to the class name.
        if(!$title = $this->instanceTitle($this->defaultTitle)) {
            $reflection = new \ReflectionClass(static::class);
            $title = $reflection->getShortName();
        }

        return $title;
    }

    /**
     * Customize the title of this report instance.
     *
     * @param string|null $title
     * @return null|string
     */
    protected function instanceTitle(string $title=null): ?string {
        # by default we will just return the static title property
        # but ideally this gets customized using the applied filters, current date, or other means.
        return $title;
    }

    /**
     * Fetch report headings
     * @return array
     */
    public function getHeadings(): array {
        return $this->headings;
    }
}