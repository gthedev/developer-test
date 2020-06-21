<?php

namespace Tests\Unit;

use App\Services\CSVGenerator\CSVGeneratorService;
use App\Services\CSVGenerator\GeneratorOptions;
use PHPUnit\Framework\TestCase;

class CSVGeneratorTest extends TestCase
{
    private CSVGeneratorService $service;
    private array $data
        = [
            'rows'     => [
                ['John', 'Doe', 'email@example.com'],
            ],
            'headings' => ['firstName', 'lastName', 'email'],
        ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = resolve(CSVGeneratorService::class);
    }

    public function test_service_generates_csv_correctly()
    {
        $csvString = $this->service->generate(
            $this->data['rows'],
            $this->data['headings']
        );

        $stringShouldBe = "firstName,lastName,email\nJohn,Doe,email@example.com\n";

        $this->assertEquals($stringShouldBe, $csvString);
    }

    public function test_service_options_affect_csv_correctly()
    {
        $options = new GeneratorOptions();

        // With headings enabled
        $options->includeHeadings = true;

        $csvString = $this->service->generate(
            $this->data['rows'],
            $this->data['headings'],
            $options
        );

        $stringShouldBe = "firstName,lastName,email\nJohn,Doe,email@example.com\n";

        $this->assertEquals($stringShouldBe, $csvString);

        // With headings disabled
        $options->includeHeadings = false;

        $csvString = $this->service->generate(
            $this->data['rows'],
            $this->data['headings'],
            $options
        );

        $stringShouldBe = "John,Doe,email@example.com\n";

        $this->assertEquals($stringShouldBe, $csvString);
    }
}
