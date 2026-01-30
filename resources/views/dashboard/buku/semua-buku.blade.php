<x-app-layout>
	@include('components.message')

	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.buku.semua-buku>
</x-app-layout>