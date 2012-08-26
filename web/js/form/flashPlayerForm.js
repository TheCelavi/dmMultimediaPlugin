$.fn.extend({
    initFlashPlayerPluginForm: function($context) {
        $('.droppable_media', $context).droppable({
            accept:       '#dm_media_bar li.file.application',
            activeClass:  'droppable_active',
            hoverClass:   'droppable_hover',
            tolerance:    'touch',
            drop:         function(event, ui) {
                $(this).val('media:' + ui.draggable.prop('id').replace(/dmm/, ''));
            }
        });
    },
    dmWidgetContentFlashPlayerForm: function() {
        this.initFlashPlayerPluginForm($(this));    
    },
    dmFlashPlayerMetadataBehaviorForm: function() {
        this.initFlashPlayerPluginForm($(this));
    }
});