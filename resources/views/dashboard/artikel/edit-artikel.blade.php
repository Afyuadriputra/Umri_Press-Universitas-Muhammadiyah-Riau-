<x-app-layout>
	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.artikel.edit-artikel :artikel="$artikel" />
</x-app-layout>