<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Schemas\Actions\Action;
use XMultibyte\BlatAdmin\Schemas\Fields\FormField;
use XMultibyte\BlatAdmin\Schemas\FormSchema;

test('form schema builds declarative configuration', function (): void {
    $schema = FormSchema::make('Create User')
        ->description('Add a new user to the system')
        ->action('/admin/users', 'POST')
        ->fields([
            FormField::make('name', 'Full Name')
                ->type('text')
                ->required()
                ->placeholder('John Doe'),
            FormField::make('email', 'Email Address')
                ->type('email')
                ->rules(['required', 'email']),
            FormField::make('role', 'Role')
                ->type('select')
                ->options(['admin' => 'Admin', 'editor' => 'Editor']),
        ])
        ->actions([
            Action::make('save', 'Save User')->color('primary'),
        ])
        ->data(['role' => 'editor']);

    expect($schema->getTitle())->toBe('Create User')
        ->and($schema->getDescription())->toBe('Add a new user to the system')
        ->and($schema->getAction())->toBe('/admin/users')
        ->and($schema->getMethod())->toBe('POST');

    $array = $schema->toArray();

    expect($array['type'])->toBe('form')
        ->and($array['title'])->toBe('Create User')
        ->and($array['fields'])->toHaveCount(3)
        ->and($array['fields'][0]['name'])->toBe('name')
        ->and($array['fields'][0]['required'])->toBeTrue()
        ->and($array['actions'])->toHaveCount(1)
        ->and($array['data'])->toBe(['role' => 'editor']);
});
