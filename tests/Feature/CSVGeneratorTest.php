<?php

namespace Tests\Feature;

use Tests\TestCase;

class CSVGeneratorTest extends TestCase
{
    public function test_it_generates_csv_correctly()
    {
        $response = $this->post(
            '/api/csv-export',
            [
                'headings' => [
                    'firstName',
                    'lastName',
                    'email',
                ],
                'rows'     => [
                    ['John', 'Doe', 'email@example.com'],
                ],
            ]
        );

        $expected = "firstName,lastName,email\nJohn,Doe,email@example.com\n";

        $response->assertStatus(200);
        $this->assertEquals($expected, $response->streamedContent());
    }

    public function test_it_generates_csv_correctly_without_headings()
    {
        $response = $this->post(
            '/api/csv-export',
            [
                'headings' => [
                    'firstName',
                    'lastName',
                    'email',
                ],
                'rows'     => [
                    ['John', 'Doe', 'email@example.com'],
                ],
                'options'  => [
                    'includeHeadings' => false,
                ],
            ]
        );

        $shouldNotBe = "firstName,lastName,email\nJohn,Doe,email@example.com\n";
        $expected = "John,Doe,email@example.com\n";
        $actual = $response->streamedContent();

        $response->assertStatus(200);
        $this->assertEquals($expected, $actual);
        $this->assertNotEquals($shouldNotBe, $actual);
    }

}
