<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Schemas\Actions\Action;
use XMultibyte\BlatAdmin\Schemas\Columns\TableColumn;
use XMultibyte\BlatAdmin\Schemas\TableSchema;

test('table schema builds declarative configuration', function (): void {
    $schema = TableSchema::make('Users')
        ->description('List of registered administrators')
        ->columns([
            TableColumn::make('id', 'ID')->sortable(),
            TableColumn::make('name', 'Name')->searchable(),
            TableColumn::make('role', 'Role')->badge(),
        ])
        ->actions([
            Action::make('edit', 'Edit')->url('/admin/users/{id}/edit'),
        ])
        ->paginate(20)
        ->data([
            ['id' => 1, 'name' => 'Alice', 'role' => 'admin'],
            ['id' => 2, 'name' => 'Bob', 'role' => 'editor'],
        ]);

    expect($schema->getTitle())->toBe('Users')
        ->and($schema->getDescription())->toBe('List of registered administrators');

    $array = $schema->toArray();

    expect($array['type'])->toBe('table')
        ->and($array['columns'])->toHaveCount(3)
        ->and($array['columns'][0]['key'])->toBe('id')
        ->and($array['columns'][0]['sortable'])->toBeTrue()
        ->and($array['columns'][2]['badge'])->toBeTrue()
        ->and($array['per_page'])->toBe(20)
        ->and($array['actions'])->toHaveCount(1)
        ->and($array['data'])->toHaveCount(2);
});
