<?php

namespace Tests\Unit;

use App\Services\CSVGenerator\CSVGeneratorService;
use PHPUnit\Framework\TestCase;

class CSVGeneratorTest extends TestCase
{
    /** @var CSVGeneratorService */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = resolve(CSVGeneratorService::class);
    }

    public function test_service_generates_csv_correctly()
    {
        $csvString = $this->service->generate(
            [
                ['John', 'Doe', 'email@example.com'],
            ],
            ['firstName', 'lastName', 'email']
        );

        $stringShouldBe = "firstName,lastName,email\nJohn,Doe,email@example.com\n";

        $this->assertEquals($stringShouldBe, $csvString);
    }
}
