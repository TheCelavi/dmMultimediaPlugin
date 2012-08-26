(function($) {    
    
    var methods = {        
        init: function(behavior) {                       
            var $this = $(this), data = $this.data('dmMultimediaPluginMetadata');
            if (data && behavior.dm_behavior_id != data.dm_behavior_id) { // There is attached the same, so we must report it
                alert('You can not attach multimedia metadata to same content'); // TODO TheCelavi - adminsitration mechanizm for this? Reporting error
            };
            $this.data('dmMultimediaPluginMetadata', behavior);
        },
        
        start: function(behavior) {  
            var $this = $(this);
            $this.attr('data-dm-multimedia-metadata', 'embedded_video');
            $this.attr('data-dm-multimedia-width', behavior.width);
            $this.attr('data-dm-multimedia-height', behavior.height);
            if (behavior.url) $this.attr('data-dm-multimedia-url', behavior.url);
        },
        stop: function(behavior) {
            var $this = $(this);
            $this.removeAttr('data-dm-multimedia-metadata');
            $this.removeAttr('data-dm-multimedia-width');
            $this.removeAttr('data-dm-multimedia-height');
            $this.removeAttr('data-dm-multimedia-url');
        },
        destroy: function(behavior) {            
            var $this = $(this);
            $this.data('dmMultimediaPluginMetadata', null);
        }
    }
    
    $.fn.dmEmbeddedVideoMetadataBehavior = function(method, behavior){
        
        return this.each(function() {
            if ( methods[method] ) {
                return methods[ method ].apply( this, [behavior]);
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, [method] );
            } else {
                $.error( 'Method ' +  method + ' does not exist on jQuery.dmEmbeddedVideoMetadataBehavior' );
            }  
        });
    };

    $.extend($.dm.behaviors, {        
        dmEmbeddedVideoMetadataBehavior: {
            init: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmEmbeddedVideoMetadataBehavior('init', behavior);
            },
            start: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmEmbeddedVideoMetadataBehavior('start', behavior);
            },
            stop: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmEmbeddedVideoMetadataBehavior('stop', behavior);
            },
            destroy: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmEmbeddedVideoMetadataBehavior('destroy', behavior);
            }
        }
    });
    
})(jQuery);