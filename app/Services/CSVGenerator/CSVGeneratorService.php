<?php

declare(strict_types=1);

namespace App\Services\CSVGenerator;

class CSVGeneratorService
{
    public function generate(array $rows, array $headings, GeneratorOptions $options = null): string
    {
        if (is_null($options)) {
            $options = new GeneratorOptions(); // Default options
        }

        ob_start();

        $handle = fopen('php://output', 'w');

        if ($options->includeHeadings) {
            fputcsv($handle, $headings);
        }

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return ob_get_clean();
    }
}