import './bootstrap';
import 'livewire-sortable'

function initPasswordToggles() {
	const buttons = document.querySelectorAll('[data-toggle-password]');
	buttons.forEach((button) => {
		if (button.dataset.bound === 'true') {
			return;
		}

		const targetId = button.getAttribute('data-target');
		const input = targetId ? document.getElementById(targetId) : null;
		if (!input) {
			return;
		}

		const showLabel = button.querySelector('[data-label="show"]');
		const hideLabel = button.querySelector('[data-label="hide"]');
		const setIconState = (isText) => {
			if (!showLabel || !hideLabel) {
				return;
			}
			if (isText) {
				showLabel.classList.add('hidden');
				hideLabel.classList.remove('hidden');
			} else {
				hideLabel.classList.add('hidden');
				showLabel.classList.remove('hidden');
			}
		};

		setIconState(input.getAttribute('type') === 'text');

		button.addEventListener('click', () => {
			const isPassword = input.getAttribute('type') === 'password';
			input.setAttribute('type', isPassword ? 'text' : 'password');
			const isNowText = input.getAttribute('type') === 'text';
			button.setAttribute('aria-pressed', String(isNowText));
			setIconState(isNowText);
		});

		button.dataset.bound = 'true';
	});
}

document.addEventListener('DOMContentLoaded', initPasswordToggles);

document.addEventListener('livewire:navigated', function () {
	initPasswordToggles();
	const darkModeToggle = document.querySelector('#darkModeToggle');
	const htmlElement = document.documentElement;

	function enableDarkMode() {
		htmlElement.classList.add('dark');
		localStorage.setItem('theme', 'dark');
	}

	function disableDarkMode() {
		htmlElement.classList.remove('dark');
		localStorage.setItem('theme', 'light');
	}

	if (localStorage.getItem('theme') === 'dark') {
		enableDarkMode();
	}

	darkModeToggle.addEventListener('click', function () {
		if (htmlElement.classList.contains('dark')) {
			disableDarkMode();
		} else {
			enableDarkMode();
		}
	});

	const backToTopBtn = document.getElementById('backToTopBtn');

	if (!backToTopBtn) {
		return;
	}
	
	function toggleBackToTopButton() {
		if (window.scrollY > 300) {
			backToTopBtn.classList.remove('opacity-0', 'invisible');
			backToTopBtn.classList.add('opacity-100');
		} else {
			backToTopBtn.classList.remove('opacity-100');
			backToTopBtn.classList.add('opacity-0', 'invisible');
		}
	}

	function scrollToTop() {
		window.scrollTo({
			top: 0,
			behavior: 'smooth'
		});
	}

	window.addEventListener('scroll', toggleBackToTopButton);

	backToTopBtn.addEventListener('click', scrollToTop);

	toggleBackToTopButton();
});
