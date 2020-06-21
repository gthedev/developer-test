<?php

namespace Tests\Unit;

use App\Services\CSVGeneratorService;
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

    public function test_it_generates_csv_correctly()
    {
        $csvString = $this->service->generate(
            [
                ['John', 'Doe', 'Email'],
            ],
            ['firstName', 'lastName', 'email']
        );

        $stringShouldBe = "firstName,lastName,email\nJohn,Doe,Email\n";

        $this->assertEquals($stringShouldBe, $csvString);
    }
}
