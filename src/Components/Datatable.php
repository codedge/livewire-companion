<?php declare(strict_types=1);

namespace Codedge\LivewireCompanion\Components;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Datatable extends Component
{
    public $perPage = 10;

    /**
     * @var string
     */
    public $sortField;

    /**
     * @var bool
     */
    public $sortAsc = true;
    protected bool $sortingEnabled = true;

    public string $searchTerm = '';
    protected string $searchField = 'name.common';
    protected bool $searchingEnabled = true;

    protected string $template = 'vendor.livewire-companion.datatable';

    /**
     * @var mixed
     */
    protected $model;

    /**
     * All secure items
     *
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected $items;

    public function render()
    {
        $this->loadModel();
        $items = $this->items->paginate($this->perPage);

        return view($this->getTemplate(), compact('items'));
    }

    private function loadModel(): void
    {
        $instance = new $this->model;

        if(!($instance instanceof \Illuminate\Database\Eloquent\Collection)) {
            $this->items = $this->loadSupportCollection($instance);
        } else {
            $this->items = $this->loadEloquentCollection($instance);
        }
    }

    private function loadSupportCollection($instance)
    {
        $sortDirectionMethod = $this->sortAsc ? 'sortBy' : 'sortByDesc';
        $collection = $instance->all();

        if(!empty($this->searchTerm)) {
            $collection = $collection->where($this->searchField, $this->searchTerm);
        }

        return collect($collection->$sortDirectionMethod($this->sortField)->all());
    }

    private function loadEloquentCollection($instance)
    {
        $instance = new $this->model;

        return $instance->where($this->searchField, 'like', '%'.$this->searchTerm.'%')
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->all();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    protected function sortingEnabled(): bool
    {
        return $this->sortingEnabled ?? config('livewire-companion.sortingEnabled');
    }

    protected function searchingEnabled(): bool
    {
        return $this->searchingEnabled ?? config('livewire-companion.searchingEnabled');
    }

    private function getTemplate(): string
    {
        return $this->template;
    }
}
