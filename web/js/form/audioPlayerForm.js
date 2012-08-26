$.fn.extend({
    initAudioPlayerPluginForm: function($context) {
        $('.droppable_media', $context).droppable({
            accept:       '#dm_media_bar li.file.audio',
            activeClass:  'droppable_active',
            hoverClass:   'droppable_hover',
            tolerance:    'touch',
            drop:         function(event, ui) {
                $(this).val('media:' + ui.draggable.prop('id').replace(/dmm/, ''));
            }
        });
    },
    dmWidgetContentAudioPlayerForm: function() {
        this.initAudioPlayerPluginForm($(this));
    },
    dmAudioPlayerMetadataBehaviorForm: function() {
        this.initAudioPlayerPluginForm($(this));
    }
});