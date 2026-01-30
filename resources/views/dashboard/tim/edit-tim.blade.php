<x-app-layout>
	<x-slot name="title">{{ $title }}</x-slot>

	<livewire:dashboard.tim.edit-tim :slug="$slug" />
</x-app-layout>