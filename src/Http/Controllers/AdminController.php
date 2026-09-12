<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Http\Controllers;

use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use XMultibyte\BlatAdmin\Facades\BlatAdmin;
use XMultibyte\BlatAdmin\Schemas\ChartSchema;
use XMultibyte\BlatAdmin\Schemas\FormSchema;
use XMultibyte\BlatAdmin\Schemas\TableSchema;

class AdminController extends Controller
{
    public function __construct(protected ViewFactory $viewFactory) {}

    /**
     * Display the admin panel dashboard overview.
     */
    public function dashboard(): View
    {
        return $this->viewFactory->make('blat-admin::pages.dashboard');
    }

    /**
     * Display a dynamic schema-driven or custom view page.
     */
    public function show(string $page): View
    {
        $pageDefinition = BlatAdmin::getPage($page);

        if ($pageDefinition instanceof Closure) {
            $pageDefinition = $pageDefinition();
        }

        if ($pageDefinition instanceof FormSchema) {
            return $this->viewFactory->make('blat-admin::pages.schema.form', ['schema' => $pageDefinition->toArray()]);
        }

        if ($pageDefinition instanceof TableSchema) {
            return $this->viewFactory->make('blat-admin::pages.schema.table', ['schema' => $pageDefinition->toArray()]);
        }

        if ($pageDefinition instanceof ChartSchema) {
            return $this->viewFactory->make('blat-admin::pages.schema.chart', ['schema' => $pageDefinition->toArray()]);
        }

        if (is_array($pageDefinition)) {
            /** @var array{type?: string, schema?: mixed} $pageArray */
            $pageArray = $pageDefinition;
            $type = $pageArray['type'] ?? (isset($pageArray['schema']['type']) ? $pageArray['schema']['type'] : null);
            $schemaData = $pageArray['schema'] ?? $pageArray;

            if ($type === 'form') {
                return $this->viewFactory->make('blat-admin::pages.schema.form', ['schema' => $schemaData]);
            }

            if ($type === 'table') {
                return $this->viewFactory->make('blat-admin::pages.schema.table', ['schema' => $schemaData]);
            }

            if ($type === 'chart') {
                return $this->viewFactory->make('blat-admin::pages.schema.chart', ['schema' => $schemaData]);
            }
        }

        if (is_string($pageDefinition) && $this->viewFactory->exists($pageDefinition)) {
            return $this->viewFactory->make($pageDefinition);
        }

        // Check custom views in user application
        $viewCandidates = [
            'admin.'.$page,
            'admin.pages.'.$page,
            'blat-admin::pages.'.$page,
        ];

        foreach ($viewCandidates as $candidate) {
            if ($this->viewFactory->exists($candidate)) {
                return $this->viewFactory->make($candidate);
            }
        }

        throw new NotFoundHttpException(sprintf('Page [%s] not found.', $page));
    }
}
