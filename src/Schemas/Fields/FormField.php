<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas\Fields;

use Illuminate\Contracts\Support\Arrayable;
use XMultibyte\BlatAdmin\Concerns\Makeable;

/**
 * @implements Arrayable<string, mixed>
 *
 * @phpstan-consistent-constructor
 */
class FormField implements Arrayable
{
    use Makeable;

    protected string $name;

    protected ?string $label = null;

    protected string $type = 'text';

    protected ?string $placeholder = null;

    protected mixed $defaultValue = null;

    /**
     * @var array<string|int, mixed>
     */
    protected array $options = [];

    /**
     * @var array<int|string, mixed>|string
     */
    protected array|string $rules = [];

    protected bool $required = false;

    protected ?string $help = null;

    protected bool $disabled = false;

    protected bool $readonly = false;

    protected ?int $span = null;

    /**
     * @var array<string, mixed>
     */
    protected array $extra = [];

    public function __construct(string $name, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? ucfirst(str_replace(['_', '-'], ' ', $name));
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function default(mixed $value): static
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * @param  array<string|int, mixed>  $options
     */
    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param  array<int|string, mixed>|string  $rules
     */
    public function rules(array|string $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    public function required(bool $required = true): static
    {
        $this->required = $required;

        return $this;
    }

    public function help(string $help): static
    {
        $this->help = $help;

        return $this;
    }

    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function readonly(bool $readonly = true): static
    {
        $this->readonly = $readonly;

        return $this;
    }

    public function span(int $span): static
    {
        $this->span = $span;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    public function extra(array $extra): static
    {
        $this->extra = array_merge($this->extra, $extra);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<int|string, mixed>|string
     */
    public function getRules(): array|string
    {
        return $this->rules;
    }

    /**
     * Convert the field into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge([
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'placeholder' => $this->placeholder,
            'default' => $this->defaultValue,
            'options' => $this->options,
            'rules' => $this->rules,
            'required' => $this->required,
            'help' => $this->help,
            'disabled' => $this->disabled,
            'readonly' => $this->readonly,
            'span' => $this->span,
        ], $this->extra);
    }
}
