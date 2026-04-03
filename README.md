# Sortable Pillbox

A Laravel Livewire component that provides a searchable pillbox UI with drag-and-drop sortable pills, powered by [SortableJS](https://sortablejs.github.io/Sortable/).

## Requirements

- PHP 8.3+
- Laravel 12 or 13
- Livewire 4+
- Tailwind CSS (for default styling)

## Installation

```bash
composer require elcheco/sortable-pillbox
```

The service provider is auto-discovered by Laravel.

## Setup

Add `@stack('scripts')` to your layout (before `</body>`) if you don't have it already — SortableJS is loaded via this stack.

## Usage

In your parent Livewire component, define the options and selected values:

```php
public array $options = [
    'name' => 'Name',
    'email' => 'Email',
    'phone' => 'Phone',
    'address' => 'Address',
];

public array $selected = ['name', 'email'];
```

Then use the component in your Blade view:

```blade
<livewire:sortable-pillbox
    wire:model="selected"
    :options="$options"
/>
```

The `selected` array is two-way bound via `wire:model` and reflects the current order of pills.

## Publishing Views

To customize the Blade template:

```bash
php artisan vendor:publish --tag=sortable-pillbox-views
```

## License

MIT
