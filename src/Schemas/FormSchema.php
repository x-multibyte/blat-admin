<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas;

use Illuminate\Database\Eloquent\Model;
use XMultibyte\BlatAdmin\Concerns\Makeable;
use XMultibyte\BlatAdmin\Contracts\SchemaContract;
use XMultibyte\BlatAdmin\Schemas\Actions\Action;
use XMultibyte\BlatAdmin\Schemas\Fields\FormField;

/**
 * @phpstan-consistent-constructor
 */
class FormSchema implements SchemaContract
{
    use Makeable;

    protected ?string $title = null;

    protected ?string $description = null;

    protected string $action = '';

    protected string $method = 'POST';

    /**
     * @var list<FormField|array<string, mixed>>
     */
    protected array $fields = [];

    /**
     * @var array<string, mixed>
     */
    protected array $rules = [];

    /**
     * @var list<Action|array<string, mixed>>
     */
    protected array $actions = [];

    /**
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * @var class-string<Model>|null
     */
    protected ?string $modelClass = null;

    public function __construct(?string $title = null)
    {
        $this->title = $title;
    }

    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function action(string $action, string $method = 'POST'): static
    {
        $this->action = $action;
        $this->method = strtoupper($method);

        return $this;
    }

    public function method(string $method): static
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * @param  list<FormField|array<string, mixed>>  $fields
     */
    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param  FormField|array<string, mixed>  $field
     */
    public function addField(FormField|array $field): static
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules(array $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param  list<Action|array<string, mixed>>  $actions
     */
    public function actions(array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @param  Action|array<string, mixed>  $action
     */
    public function addAction(Action|array $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function data(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    public function model(string $modelClass): static
    {
        $this->modelClass = $modelClass;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getFields(): array
    {
        return array_map(function (FormField|array $field): array {
            return $field instanceof FormField ? $field->toArray() : $field;
        }, $this->fields);
    }

    /**
     * @return array<string, mixed>
     */
    public function getRules(): array
    {
        $computedRules = $this->rules;

        foreach ($this->fields as $field) {
            if ($field instanceof FormField) {
                $name = $field->getName();
                $rules = $field->getRules();

                if (! empty($rules) && ! isset($computedRules[$name])) {
                    $computedRules[$name] = $rules;
                }
            }
        }

        return $computedRules;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getActions(): array
    {
        return array_map(function (Action|array $action): array {
            return $action instanceof Action ? $action->toArray() : $action;
        }, $this->actions);
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Convert the schema into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => 'form',
            'title' => $this->title,
            'description' => $this->description,
            'action' => $this->action,
            'method' => $this->method,
            'fields' => $this->getFields(),
            'rules' => $this->getRules(),
            'actions' => $this->getActions(),
            'data' => $this->data,
            'model' => $this->modelClass,
        ];
    }
}
