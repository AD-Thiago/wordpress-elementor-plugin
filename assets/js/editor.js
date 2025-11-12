/**
 * Elementor Neo Plugin - Editor Scripts
 * Scripts specific to Elementor editor
 */

(function($) {
    'use strict';

    /**
     * Editor Enhancement Object
     */
    const ElementorNeoEditor = {
        
        /**
         * Initialize Editor Enhancements
         */
        init() {
            // Wait for Elementor editor to be ready
            $(window).on('elementor:init', this.onElementorInit.bind(this));
        },

        /**
         * Elementor Init Handler
         */
        onElementorInit() {
            console.log('Elementor Neo Editor Scripts loaded');
            
            // Add editor-specific features
            this.addEditorPanelEnhancements();
            this.registerEditorEvents();
        },

        /**
         * Add Editor Panel Enhancements
         */
        addEditorPanelEnhancements() {
            // Add custom CSS to editor
            elementor.hooks.addAction('panel/open_editor/widget', (panel, model, view) => {
                console.log('Widget panel opened:', model.get('widgetType'));
            });
        },

        /**
         * Register Editor Events
         */
        registerEditorEvents() {
            // Listen to widget changes
            elementor.channels.data.on('element:after:add', (model) => {
                if (model.get('widgetType') === 'neo_example_widget') {
                    console.log('Neo Example Widget added');
                    this.onNeoWidgetAdded(model);
                }
            });

            // Listen to widget removal
            elementor.channels.data.on('element:before:remove', (model) => {
                if (model.get('widgetType') === 'neo_example_widget') {
                    console.log('Neo Example Widget removed');
                }
            });
        },

        /**
         * Handle Neo Widget Addition
         */
        onNeoWidgetAdded(model) {
            // Add default settings or perform actions when widget is added
            const settings = model.get('settings');
            
            // Example: Set default title if empty
            if (!settings.get('title')) {
                settings.set('title', 'Neo Example Widget');
            }
        },

        /**
         * Utility: Get Widget by ID
         */
        getWidgetById(id) {
            return elementor.getPreviewView().children.findByModelCid(id);
        }
    };

    /**
     * Initialize on Document Ready
     */
    $(window).on('elementor/frontend/init', () => {
        ElementorNeoEditor.init();
    });

    /**
     * Expose to global scope
     */
    window.ElementorNeoEditor = ElementorNeoEditor;

})(jQuery);
