<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Schemas\ChartSchema;

test('chart schema builds declarative analytics configuration', function (): void {
    $schema = ChartSchema::make('Monthly Revenue')
        ->description('Sales overview for the current year')
        ->type('area')
        ->series([
            ['name' => 'Revenue', 'data' => [100, 200, 150, 300]],
        ])
        ->categories(['Q1', 'Q2', 'Q3', 'Q4'])
        ->height(400)
        ->colors(['#4f46e5']);

    expect($schema->getTitle())->toBe('Monthly Revenue')
        ->and($schema->getType())->toBe('area')
        ->and($schema->getHeight())->toBe(400);

    $array = $schema->toArray();

    expect($array['type'])->toBe('chart')
        ->and($array['chart_type'])->toBe('area')
        ->and($array['title'])->toBe('Monthly Revenue')
        ->and($array['series'])->toHaveCount(1)
        ->and($array['categories'])->toBe(['Q1', 'Q2', 'Q3', 'Q4'])
        ->and($array['colors'])->toBe(['#4f46e5']);
});
