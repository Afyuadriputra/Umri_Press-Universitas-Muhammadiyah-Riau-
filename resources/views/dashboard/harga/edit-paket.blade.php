<x-app-layout>
	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.harga.edit-harga :slug="$slug" />
</x-app-layout>