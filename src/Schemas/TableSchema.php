<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use XMultibyte\BlatAdmin\Concerns\Makeable;
use XMultibyte\BlatAdmin\Contracts\SchemaContract;
use XMultibyte\BlatAdmin\Schemas\Actions\Action;
use XMultibyte\BlatAdmin\Schemas\Columns\TableColumn;

/**
 * @phpstan-consistent-constructor
 */
class TableSchema implements SchemaContract
{
    use Makeable;

    protected ?string $title = null;

    protected ?string $description = null;

    /**
     * @var list<TableColumn|array<string, mixed>>
     */
    protected array $columns = [];

    /**
     * @var bool|list<string>
     */
    protected bool|array $sortable = true;

    /**
     * @var bool|list<string>
     */
    protected bool|array $searchable = true;

    protected int $perPage = 15;

    /**
     * @var list<Action|array<string, mixed>>
     */
    protected array $actions = [];

    /**
     * @var list<Action|array<string, mixed>>
     */
    protected array $bulkActions = [];

    protected mixed $data = null;

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

    /**
     * @param  list<TableColumn|array<string, mixed>>  $columns
     */
    public function columns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param  TableColumn|array<string, mixed>  $column
     */
    public function addColumn(TableColumn|array $column): static
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @param  bool|list<string>  $sortable
     */
    public function sortable(bool|array $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * @param  bool|list<string>  $searchable
     */
    public function searchable(bool|array $searchable = true): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function paginate(int $perPage = 15): static
    {
        $this->perPage = $perPage;

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
     * @param  list<Action|array<string, mixed>>  $bulkActions
     */
    public function bulkActions(array $bulkActions): static
    {
        $this->bulkActions = $bulkActions;

        return $this;
    }

    public function data(mixed $data): static
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

    /**
     * @return list<array<string, mixed>>
     */
    public function getColumns(): array
    {
        return array_map(function (TableColumn|array $column): array {
            return $column instanceof TableColumn ? $column->toArray() : $column;
        }, $this->columns);
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
     * @return list<array<string, mixed>>
     */
    public function getBulkActions(): array
    {
        return array_map(function (Action|array $action): array {
            return $action instanceof Action ? $action->toArray() : $action;
        }, $this->bulkActions);
    }

    /**
     * Resolve records for rendering.
     */
    public function resolveData(): mixed
    {
        if ($this->data !== null) {
            return $this->data;
        }

        if ($this->modelClass !== null && class_exists($this->modelClass)) {
            /** @var Builder<Model> $query */
            $query = $this->modelClass::query();

            return $query->paginate($this->perPage);
        }

        return [];
    }

    /**
     * Convert the schema into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $resolvedData = $this->resolveData();

        /** @var mixed $dataArray */
        $dataArray = $resolvedData;

        if ($resolvedData instanceof Arrayable) {
            $dataArray = $resolvedData->toArray();
        }

        return [
            'type' => 'table',
            'title' => $this->title,
            'description' => $this->description,
            'columns' => $this->getColumns(),
            'sortable' => $this->sortable,
            'searchable' => $this->searchable,
            'per_page' => $this->perPage,
            'actions' => $this->getActions(),
            'bulk_actions' => $this->getBulkActions(),
            'data' => $dataArray,
            'model' => $this->modelClass,
        ];
    }
}
