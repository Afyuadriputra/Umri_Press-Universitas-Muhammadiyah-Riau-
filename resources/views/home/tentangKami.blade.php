<x-main-layout>
	<x-slot name="title">{{ $title }}</x-slot>

	<!-- Hero Section -->
	<section class="pt-16 pb-24 ">
		 <x-container>
			  <div class="grid lg:grid-cols-2 gap-12 items-center">
					<div class="space-y-6">
						 <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-cgreen-500 dark:text-cgreen-400 rounded-full bg-cgreen-50 dark:bg-cgreen-900/50">
							  Tentang Kami
						 </span>
						 <h1 class="text-4xl font-bold text-neutral-900 dark:text-neutral-100">UMRI Press - Penerbit Akademik Bereputasi</h1>
						 <p class="text-lg text-neutral-600 dark:text-neutral-400">
							  Sejak didirikan, UMRI Press telah berkomitmen untuk menjadi penerbit akademik yang berkualitas dan terpercaya dalam mendukung publikasi karya ilmiah.
						 </p>
					</div>
					<div class="relative">
						 <div class="relative h-[400px] rounded-2xl overflow-hidden">
							  <img src="{{ asset('assets/img/banner/universitas.jpg') }}" alt="UMRI Press Building" 
									class="absolute inset-0 w-full h-full object-cover">
							  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
						 </div>
					</div>
			  </div>
		 </x-container>
	</section>

	<!-- Vision & Mission -->
	<section class="py-24 bg-white dark:bg-neutral-900">
		 <x-container>
			  <div class="grid md:grid-cols-2 gap-12">
					<!-- Vision -->
					<div class="bg-neutral-50 dark:bg-neutral-800 p-8 rounded-2xl">
						 <div class="w-14 h-14 bg-cgreen-100 dark:bg-cgreen-900/50 rounded-xl flex items-center justify-center mb-6">
							  <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
							  </svg>
						 </div>
						 <h3 class="text-2xl font-semibold mb-4 text-neutral-900 dark:text-neutral-100">Visi</h3>
						 <p class="text-neutral-600 dark:text-neutral-400">
							  Menjadi penerbit akademik terkemuka yang berkomitmen dalam menyebarluaskan pengetahuan melalui publikasi karya ilmiah berkualitas tinggi.
						 </p>
					</div>

					<!-- Mission -->
					<div class="bg-neutral-50 dark:bg-neutral-800 p-8 rounded-2xl">
						 <div class="w-14 h-14 bg-cgreen-100 dark:bg-cgreen-900/50 rounded-xl flex items-center justify-center mb-6">
							  <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
							  </svg>
						 </div>
						 <h3 class="text-2xl font-semibold mb-4 text-neutral-900 dark:text-neutral-100">Misi</h3>
						 <ul class="space-y-3 text-neutral-600 dark:text-neutral-400">
							  <li class="flex items-start gap-3">
									<svg class="w-5 h-5 text-cgreen-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
									</svg>
									<span>Menerbitkan karya ilmiah berkualitas tinggi</span>
							  </li>
							  <li class="flex items-start gap-3">
									<svg class="w-5 h-5 text-cgreen-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
									</svg>
									<span>Mendukung pengembangan ilmu pengetahuan</span>
							  </li>
							  <li class="flex items-start gap-3">
									<svg class="w-5 h-5 text-cgreen-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
									</svg>
									<span>Memberikan layanan penerbitan profesional</span>
							  </li>
						 </ul>
					</div>
			  </div>
		 </x-container>
	</section>

	<!-- Features -->
	<section class="py-24 bg-neutral-50 dark:bg-neutral-950">
		 <x-container>
			  <div class="text-center max-w-3xl mx-auto mb-16">
					<h2 class="text-3xl font-bold mb-4">Keunggulan Kami</h2>
					<p class="text-neutral-600 dark:text-neutral-400">
						 UMRI Press memiliki berbagai keunggulan yang menjadikan kami pilihan tepat untuk menerbitkan karya ilmiah Anda
					</p>
			  </div>

			  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
					<!-- Feature 1 -->
					<div class="bg-white dark:bg-neutral-900 p-8 rounded-2xl">
						 <div class="w-14 h-14 bg-cgreen-100 dark:bg-cgreen-900/50 rounded-xl flex items-center justify-center mb-6">
							  <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
							  </svg>
						 </div>
						 <h3 class="text-xl font-semibold mb-3 text-neutral-900 dark:text-neutral-100">Kualitas Terjamin</h3>
						 <p class="text-neutral-600 dark:text-neutral-400">
							  Proses editorial dan produksi yang ketat untuk memastikan kualitas terbaik setiap publikasi
						 </p>
					</div>

					<!-- Feature 2 -->
					<div class="bg-white dark:bg-neutral-900 p-8 rounded-2xl">
						 <div class="w-14 h-14 bg-cgreen-100 dark:bg-cgreen-900/50 rounded-xl flex items-center justify-center mb-6">
							  <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
							  </svg>
						 </div>
						 <h3 class="text-xl font-semibold mb-3 text-neutral-900 dark:text-neutral-100">Tim Profesional</h3>
						 <p class="text-neutral-600 dark:text-neutral-400">
							  Didukung oleh tim editor dan desainer yang berpengalaman di bidangnya
						 </p>
					</div>

					<!-- Feature 3 -->
					<div class="bg-white dark:bg-neutral-900 p-8 rounded-2xl">
						 <div class="w-14 h-14 bg-cgreen-100 dark:bg-cgreen-900/50 rounded-xl flex items-center justify-center mb-6">
							  <svg class="w-8 h-8 text-cgreen-600 dark:text-cgreen-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
							  </svg>
						 </div>
						 <h3 class="text-xl font-semibold mb-3 text-neutral-900 dark:text-neutral-100">Proses Cepat</h3>
						 <p class="text-neutral-600 dark:text-neutral-400">
							  Waktu penerbitan yang efisien dengan komunikasi yang responsif
						 </p>
					</div>
			  </div>
		 </x-container>
	</section>

	<!-- CTA Section -->
	<section class="py-20 bg-cgreen-500 dark:bg-cgreen-900">
		 <x-container>
			  <div class="text-center">
					<h2 class="text-3xl font-bold text-white mb-4">Siap Menerbitkan Karya Anda?</h2>
					<p class="text-cgreen-100 mb-8 max-w-2xl mx-auto">
						 Mari wujudkan impian Anda menjadi penulis bersama UMRI Press. Kami siap membantu menerbitkan karya terbaik Anda.
					</p>
					<div class="flex flex-wrap justify-center gap-4">
						 <a href="{{ route('daftarPenulis') }}" wire:navigate>
							  <x-light-button>
									Daftar Sekarang
							  </x-light-button>
						 </a>
						 <a href="{{ route('kontak') }}" wire:navigate>
							  <x-secondary-button class="!bg-transparent hover:!bg-cgreen-800/40">
									Hubungi Kami
							  </x-secondary-button>
						 </a>
					</div>
			  </div>
		 </x-container>
	</section>
</x-main-layout>