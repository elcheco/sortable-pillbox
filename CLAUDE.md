# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

`elcheco/sortable-pillbox` is a Laravel Livewire 4 component package that provides a searchable pillbox UI with drag-and-drop sortable pills using SortableJS. Users can select items from an "available" pool and reorder them in a "selected" row via drag-and-drop or click.

## Architecture

- **Service Provider** (`src/SortablePillboxServiceProvider.php`): Registers the Livewire component and views. Auto-discovered via `composer.json` extra.laravel.providers.
- **Livewire Component** (`src/Livewire/SortablePillbox.php`): Minimal PHP component with `#[Modelable]` `$selected` array and `$options` array. State is two-way bound via `wire:model`.
- **Blade View** (`resources/views/livewire/sortable-pillbox.blade.php`): Contains all UI logic in an Alpine.js `x-data` block. DOM is manually rendered (not Alpine-templated) to work with SortableJS — `renderAvailable()` and `renderSelected()` build pills imperatively. Uses `$wire.entangle('selected')` for Livewire sync and `syncFromDom()` to read order back after drag operations.

## Key Design Decisions

- Pills are rendered via imperative DOM manipulation (not Alpine `x-for`) because SortableJS mutates the DOM directly — Alpine reactivity would fight it.
- SortableJS is loaded from CDN via `@push('scripts')`, requiring the host app to have a `@stack('scripts')` in its layout.
- Two SortableJS instances share a named group (`fields-{id}`) with `pull: 'clone'` on available and `pull: true` on selected.
- Tailwind CSS classes with dark mode support are used throughout.

## Requirements

- PHP 8.3+, Laravel 12 or 13, Livewire 4+
