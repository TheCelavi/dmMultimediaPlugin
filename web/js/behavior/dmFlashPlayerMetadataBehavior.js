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
            $this.attr('data-dm-multimedia-metadata', 'flash_player');
            $this.attr('data-dm-multimedia-width', behavior.width);
            $this.attr('data-dm-multimedia-height', behavior.height);
            $this.attr('data-dm-multimedia-allowFullScreen', behavior.allowFullScreen);
            $this.attr('data-dm-multimedia-allowScriptAccess', behavior.allowScriptAccess);
            $this.attr('data-dm-multimedia-play', behavior.play);
            $this.attr('data-dm-multimedia-loop', behavior.loop);
            $this.attr('data-dm-multimedia-menu', behavior.menu);
            $this.attr('data-dm-multimedia-quality', behavior.quality);
            $this.attr('data-dm-multimedia-scale', behavior.scale);
            $this.attr('data-dm-multimedia-base', behavior.base);
            $this.attr('data-dm-multimedia-flashVars', behavior.flashVars);
            if (behavior.url) $this.attr('data-dm-multimedia-url', behavior.url);
        },
        stop: function(behavior) {
            var $this = $(this);
            $this.removeAttr('data-dm-multimedia-metadata');
            $this.removeAttr('data-dm-multimedia-width');
            $this.removeAttr('data-dm-multimedia-height');
            $this.removeAttr('data-dm-multimedia-allowFullScreen');
            $this.removeAttr('data-dm-multimedia-allowScriptAccess');
            $this.removeAttr('data-dm-multimedia-play');
            $this.removeAttr('data-dm-multimedia-loop');
            $this.removeAttr('data-dm-multimedia-menu');
            $this.removeAttr('data-dm-multimedia-quality');
            $this.removeAttr('data-dm-multimedia-scale');
            $this.removeAttr('data-dm-multimedia-base');
            $this.removeAttr('data-dm-multimedia-flashVars');
            $this.removeAttr('data-dm-multimedia-url');
        },
        destroy: function(behavior) {            
            var $this = $(this);
            $this.data('dmMultimediaPluginMetadata', null);
        }
    }
    
    $.fn.dmFlashPlayerMetadataBehavior = function(method, behavior){
        
        return this.each(function() {
            if ( methods[method] ) {
                return methods[ method ].apply( this, [behavior]);
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, [method] );
            } else {
                $.error( 'Method ' +  method + ' does not exist on jQuery.dmFlashPlayerMetadataBehavior' );
            }  
        });
    };

    $.extend($.dm.behaviors, {        
        dmFlashPlayerMetadataBehavior: {
            init: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmFlashPlayerMetadataBehavior('init', behavior);
            },
            start: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmFlashPlayerMetadataBehavior('start', behavior);
            },
            stop: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmFlashPlayerMetadataBehavior('stop', behavior);
            },
            destroy: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmFlashPlayerMetadataBehavior('destroy', behavior);
            }
        }
    });
    
})(jQuery);