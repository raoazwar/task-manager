import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Livewire Preloader
if (window.Livewire) {
    document.addEventListener('alpine:init', () => {
        Alpine.data('livewireLoader', () => ({
            loading: false,
            init() {
                window.Livewire.hook('message.sent', () => {
                    this.loading = true;
                });
                window.Livewire.hook('message.processed', () => {
                    this.loading = false;
                });
            }
        }));
    });
}

// Inject loader HTML if not present
if (!document.getElementById('livewire-preloader')) {
    const loader = document.createElement('div');
    loader.id = 'livewire-preloader';
    loader.setAttribute('x-data', 'livewireLoader');
    loader.setAttribute('x-show', 'loading');
    loader.setAttribute('x-cloak', '');
    loader.innerHTML = `
        <div style="position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.85);display:flex;align-items:center;justify-content:center;">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-16 w-16 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span class="text-indigo-700 text-lg font-semibold">Loading...</span>
            </div>
        </div>
    `;
    document.body.appendChild(loader);
}