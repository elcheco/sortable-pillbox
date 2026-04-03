<div
    x-data="{
        options: @js($options),
        selected: $wire.entangle('selected'),
        dragging: false,
        get available() {
            return Object.keys(this.options).filter(k => !this.selected.includes(k))
        },
        add(key) {
            this.selected = [...this.selected, key]
        },
        remove(key) {
            this.selected = this.selected.filter(k => k !== key)
        },
        renderAvailable() {
            const container = this.$refs.availableRow
            if (!container) return
            container.innerHTML = ''
            this.available.forEach(key => {
                const pill = document.createElement('span')
                pill.dataset.key = key
                pill.textContent = this.options[key]
                pill.className = 'inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-800 px-2 py-1 text-sm cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-700 select-none'
                pill.addEventListener('click', () => this.add(key))
                container.appendChild(pill)
            })
        },
        renderSelected() {
            const container = this.$refs.selectedRow
            if (!container) return
            container.innerHTML = ''
            this.selected.forEach(key => {
                if (!this.options[key]) return
                const pill = document.createElement('span')
                pill.dataset.key = key
                pill.className = 'inline-flex items-center gap-1 rounded-md bg-zinc-400/15 dark:bg-zinc-400/40 px-2 py-1 text-sm font-medium cursor-grab select-none'
                const label = document.createElement('span')
                label.textContent = this.options[key]
                const btn = document.createElement('button')
                btn.type = 'button'
                btn.className = 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 cursor-pointer'
                btn.innerHTML = `<svg class='size-3.5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'><path d='M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z'/></svg>`
                btn.addEventListener('click', () => this.remove(key))
                pill.appendChild(label)
                pill.appendChild(btn)
                container.appendChild(pill)
            })
        },
        render() {
            this.renderAvailable()
            this.renderSelected()
        },
        syncFromDom() {
            const selKeys = [...this.$refs.selectedRow.children].map(el => el.dataset.key)
            this.dragging = false
            this.selected = selKeys
        },
        init() {
            this.$nextTick(() => {
                this.render()
                new Sortable(this.$refs.availableRow, {
                    group: { name: 'fields-' + this.$id('pillbox'), pull: 'clone', put: true },
                    sort: false,
                    animation: 150,
                    ghostClass: 'opacity-30',
                    onAdd: () => { this.syncFromDom() },
                    onEnd: (evt) => {
                        if (evt.to === this.$refs.selectedRow) {
                            this.syncFromDom()
                        } else if (evt.item.parentNode) {
                            evt.item.parentNode.removeChild(evt.item)
                        }
                    }
                })
                new Sortable(this.$refs.selectedRow, {
                    group: { name: 'fields-' + this.$id('pillbox'), pull: true, put: true },
                    animation: 150,
                    ghostClass: 'opacity-30',
                    onStart: () => { this.dragging = true },
                    onEnd: () => { this.syncFromDom() }
                })
            })
            this.$watch('selected', () => {
                if (!this.dragging) {
                    this.$nextTick(() => this.render())
                }
            })
        }
    }"
>
    {{-- SortableJS CDN --}}
    @once
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
        @endpush
    @endonce

    <div>
        <div x-ref="availableRow" wire:ignore class="min-h-[2.5rem] rounded-lg border border-zinc-200 dark:border-zinc-700 p-2 flex flex-wrap gap-1">
        </div>
        <span x-show="available.length === 0" class="text-sm text-zinc-400 italic mt-1">{{ __('No more options') }}</span>
    </div>

    <div class="mt-2">
        <div x-ref="selectedRow" wire:ignore class="min-h-[2.5rem] rounded-lg border border-zinc-200 dark:border-zinc-700 p-2 flex flex-wrap gap-1">
        </div>
        <span x-show="selected.length === 0" class="text-sm text-zinc-400 italic mt-1">{{ __('Click a field above to add it') }}</span>
    </div>
</div>
