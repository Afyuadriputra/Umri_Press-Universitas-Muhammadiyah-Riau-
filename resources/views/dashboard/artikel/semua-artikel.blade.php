<x-app-layout>
	@include('components.message')
	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.artikel.semua-artikel />
</x-app-layout>