<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchableSelect extends Component
{
    public $name;
    public $placeholder;
    public $items = [];
    public $search = '';
    public $selected = null;
    public $selectedText = '';
    public $showDropdown = false;
    public $disabled = false;
    public $multiple = false;

    protected $listeners = ['clear' => 'clearSelection'];

    public function mount($name, $items = [], $placeholder = 'Select an option...', $selected = null, $multiple = false)
    {
        $this->name = $name;
        $this->items = $items;
        $this->placeholder = $placeholder;
        $this->multiple = $multiple;

        if ($this->multiple) {
            $this->selected = is_array($selected) ? $selected : [];
            $this->selectedText = collect($this->selected)->map(function ($val) {
                return $this->items[$val] ?? '';
            })->values()->toArray();
        } else {
            if ($selected) {
                $this->selected = $selected;
                $this->selectedText = $this->items[$selected] ?? '';
            } else {
                $this->selectedText = '';
            }
        }
    }

    public function getFilteredItemsProperty()
    {
        if (strlen($this->search) < 3) {
            $this->placeholder = 'Type at least 3 characters...';
            return [];
        }

        if (empty($this->search)) {
            return $this->items;
        }

        return collect($this->items)->filter(function ($item) {
            return str_contains(strtolower($item), strtolower($this->search));
        })->toArray();
    }

    public function selectItem($value, $text)
    {
        if ($this->multiple) {
            if (!in_array($value, $this->selected)) {
                $this->selected[] = $value;
                $this->selectedText = array_values(array_merge($this->selectedText, [$text]));
            }
            $this->dispatch('item-selected', [
                'name' => $this->name,
                'value' => $this->selected
            ]);
        } else {
            $this->selected = $value;
            $this->selectedText = $text;
            $this->showDropdown = false;
            $this->search = '';
            $this->dispatch('item-selected', [
                'name' => $this->name,
                'value' => $value
            ]);
        }
        $this->showDropdown = false;
        $this->search = '';
    }

    public function clearSelection($value = null)
    {
        if ($this->multiple) {
            if ($value !== null) {
                $index = array_search($value, $this->selected);
                if ($index !== false) {
                    array_splice($this->selected, $index, 1);
                    array_splice($this->selectedText, $index, 1);
                }
            } else {
                $this->selected = [];
                $this->selectedText = [];
            }
            $this->dispatch('item-selected', [
                'name' => $this->name,
                'value' => $this->selected
            ]);
        } else {
            $this->selected = null;
            $this->selectedText = '';
            $this->search = '';
            $this->dispatch('item-selected', [
                'name' => $this->name,
                'value' => null
            ]);
        }
    }

    public function toggleDropdown()
    {
        if (!$this->disabled) {
            $this->showDropdown = !$this->showDropdown;
        }
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
        $this->search = '';
    }

    public function updatedSearch()
    {
        $this->showDropdown = true;
    }

    public function render()
    {
        return view('livewire.components.searchable-select');
    }
}
