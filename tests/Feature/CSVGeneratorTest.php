<?php

namespace Tests\Feature;

use Tests\TestCase;

class CSVGeneratorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
}
