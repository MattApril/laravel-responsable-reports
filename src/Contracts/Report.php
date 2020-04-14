<?php
declare(strict_types=1);

namespace MattApril\ResponsableReports\Contracts;

/**
 * Interface Report
 *
 * @author Matthew April
 */
interface Report
{
    /**
     * Sets all filters
     * @param array $filters
     * @return mixed
     */
    public function setFilters( array $filters ): void;

    /**
     * Apply additional filters
     * @param array $filters
     * @return mixed
     */
    public function addFilters( array $filters ): void;

    /**
     * @return array
     */
    public function getFilters(): array;

    /**
     * Gets the title of the report
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get report heading titles, order should match keys in data set
     * @return array
     */
    public function getHeadings(): array;

    /**
     * Generate full report data set for export
     * @return array
     */
    public function getFullReport(): array;
}