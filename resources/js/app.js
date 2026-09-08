import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('navSearchApp', (initialQuery = '') => ({
    mobileMenuOpen: false,
    mobileSearchOpen: false,
    profileDropdown: false,
    infoDropdown: false,
    layananDropdown: false,
    literasiDropdown: false,
    searchQuery: initialQuery,
    searchResults: [],
    searchLoading: false,
    searchOpen: false,
    isScrolled: false,
    init() {
        this.isScrolled = window.scrollY > 10;
        window.addEventListener('scroll', () => {
            this.isScrolled = window.scrollY > 10;
        }, { passive: true });
    },
    fetchSuggestions() {
        if (this.searchQuery.trim().length < 2) {
            this.searchResults = [];
            this.searchOpen = false;
            return;
        }
        this.searchLoading = true;
        this.searchOpen = true;
        fetch('/api/search?q=' + encodeURIComponent(this.searchQuery))
            .then(res => res.json())
            .then(data => {
                this.searchResults = data.results || [];
                this.searchLoading = false;
            })
            .catch(err => {
                this.searchLoading = false;
                this.searchResults = [];
            });
    }
}));

window.navSearchApp = function(initialQuery = '') {
    return {
        mobileMenuOpen: false,
        mobileSearchOpen: false,
        profileDropdown: false,
        infoDropdown: false,
        layananDropdown: false,
        literasiDropdown: false,
        searchQuery: initialQuery,
        searchResults: [],
        searchLoading: false,
        searchOpen: false,
        isScrolled: false,
        init() {
            this.isScrolled = window.scrollY > 10;
            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 10;
            }, { passive: true });
        },
        fetchSuggestions() {
            if (this.searchQuery.trim().length < 2) {
                this.searchResults = [];
                this.searchOpen = false;
                return;
            }
            this.searchLoading = true;
            this.searchOpen = true;
            fetch('/api/search?q=' + encodeURIComponent(this.searchQuery))
                .then(res => res.json())
                .then(data => {
                    this.searchResults = data.results || [];
                    this.searchLoading = false;
                })
                .catch(err => {
                    this.searchLoading = false;
                    this.searchResults = [];
                });
        }
    };
};

Alpine.start();
