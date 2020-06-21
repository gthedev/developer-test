<?php


namespace App\Services\CSVGenerator;


class GeneratorOptions
{
    public bool $includeHeadings = true;

    public static function fromArray(array $options)
    {
        $instance = new self();

        if (!is_null($includeHeadings = data_get($options, 'includeHeadings'))) {
            $instance->includeHeadings = !!$includeHeadings;
        }

        return $instance;
    }
}