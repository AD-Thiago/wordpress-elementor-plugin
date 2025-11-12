/**
 * Elementor Neo Plugin Scripts
 * Modern JavaScript with best practices
 */

(function($) {
    'use strict';

    /**
     * Main Plugin Object
     */
    const ElementorNeoPlugin = {
        
        /**
         * Initialize
         */
        init() {
            this.bindEvents();
            this.initWidgets();
        },

        /**
         * Bind DOM Events
         */
        bindEvents() {
            $(window).on('load', this.onWindowLoad.bind(this));
            $(document).on('ready', this.onDocumentReady.bind(this));
        },

        /**
         * Window Load Handler
         */
        onWindowLoad() {
            console.log('Elementor Neo Plugin loaded');
            this.animateWidgets();
        },

        /**
         * Document Ready Handler
         */
        onDocumentReady() {
            this.setupAccessibility();
        },

        /**
         * Initialize Widgets
         */
        initWidgets() {
            const widgets = document.querySelectorAll('.neo-example-widget');
            
            widgets.forEach(widget => {
                // Add intersection observer for lazy loading
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver(
                        (entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    entry.target.classList.add('neo-widget-animated');
                                    observer.unobserve(entry.target);
                                }
                            });
                        },
                        { threshold: 0.1 }
                    );
                    observer.observe(widget);
                }
            });
        },

        /**
         * Animate Widgets
         */
        animateWidgets() {
            const widgets = $('.neo-example-widget');
            
            widgets.each(function(index) {
                const $widget = $(this);
                setTimeout(() => {
                    $widget.addClass('neo-widget-animated');
                }, index * 100);
            });
        },

        /**
         * Setup Accessibility
         */
        setupAccessibility() {
            // Add ARIA labels
            $('.neo-widget-title').attr('role', 'heading').attr('aria-level', '2');
            
            // Keyboard navigation
            $('.neo-example-widget').attr('tabindex', '0');
        },

        /**
         * Utility: Debounce Function
         */
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    };

    /**
     * Initialize on DOM Ready
     */
    $(document).ready(() => {
        ElementorNeoPlugin.init();
    });

    /**
     * Expose to global scope if needed
     */
    window.ElementorNeoPlugin = ElementorNeoPlugin;

})(jQuery);
