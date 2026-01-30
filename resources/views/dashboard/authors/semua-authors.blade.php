<x-app-layout>
	@include('components.message')

	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.authors.semua-authors />
</x-app-layout>