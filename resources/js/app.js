import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

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
    showScrollTop: false,
    init() {
        this.isScrolled = window.scrollY > 15;
        this.showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200;
        window.addEventListener('scroll', () => {
            this.isScrolled = window.scrollY > 15;
            this.showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200;
        }, { passive: true });
    },
    fetchSuggestions() {
        const query = this.searchQuery.trim();
        if (query.length < 2) {
            this.searchResults = [];
            this.searchOpen = false;
            return;
        }
        this.searchLoading = true;
        this.searchOpen = true;
        fetch('/api/search?q=' + encodeURIComponent(query), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                this.searchResults = data.results || [];
                this.searchLoading = false;
            })
            .catch(err => {
                console.error('Search fetch error:', err);
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
        showScrollTop: false,
        init() {
            this.isScrolled = window.scrollY > 15;
            this.showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200;
            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 15;
                this.showScrollTop = (window.pageYOffset || document.documentElement.scrollTop) > 200;
            }, { passive: true });
        },
        fetchSuggestions() {
            const query = this.searchQuery.trim();
            if (query.length < 2) {
                this.searchResults = [];
                this.searchOpen = false;
                return;
            }
            this.searchLoading = true;
            this.searchOpen = true;
            fetch('/api/search?q=' + encodeURIComponent(query), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    this.searchResults = data.results || [];
                    this.searchLoading = false;
                })
                .catch(err => {
                    console.error('Search fetch error:', err);
                    this.searchLoading = false;
                    this.searchResults = [];
                });
        }
    };
};

Alpine.start();
