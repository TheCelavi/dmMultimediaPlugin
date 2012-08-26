$.fn.extend({
    initVideoPlayerPluginForm: function($context) {
        $('.droppable_video', $context).droppable({
            accept:       '#dm_media_bar li.file.video',
            activeClass:  'droppable_active',
            hoverClass:   'droppable_hover',
            tolerance:    'touch',
            drop:         function(event, ui) {
                $(this).val('media:' + ui.draggable.prop('id').replace(/dmm/, ''));
            }
        });
        $('.droppable_image', $(this)).droppable({
            accept:       '#dm_media_bar li.file.image',
            activeClass:  'droppable_active',
            hoverClass:   'droppable_hover',
            tolerance:    'touch',
            drop:         function(event, ui) {
                $(this).val('media:' + ui.draggable.prop('id').replace(/dmm/, ''));
            }
        });
    },
    dmWidgetContentVideoPlayerForm: function() {
        this.initVideoPlayerPluginForm($(this));
    },
    dmVideoPlayerMetadataBehaviorForm: function() {
        this.initVideoPlayerPluginForm($(this));
    }
});