<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CSVGenerator\CSVGeneratorService;
use App\Services\CSVGenerator\GeneratorOptions;
use Illuminate\Http\Request;

class CsvExportController extends Controller
{
    /**
     * Converts the user input into a CSV file and streams the file back to the user
     *
     * @param  Request  $request
     * @param  CSVGeneratorService  $service
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function convert(Request $request, CSVGeneratorService $service)
    {
        $request->validate(
            [
                'headings' => 'required|array',
                'rows'     => 'required|array',
                'options'  => 'array',
            ]
        );

        $options = GeneratorOptions::fromArray($request->input('options', []));

        $csv = $service->generate($request->input('rows'), $request->input('headings'), $options);

        return response()->streamDownload(
            function () use ($csv) {
                echo $csv;
            },
            'csv-export-'.date('Y-m-d-H-i-s').'.csv',
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }
}
