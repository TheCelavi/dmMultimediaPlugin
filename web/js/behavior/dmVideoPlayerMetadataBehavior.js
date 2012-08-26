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
            $this.attr('data-dm-multimedia-metadata', 'video_player');
            $this.attr('data-dm-multimedia-width', behavior.width);
            $this.attr('data-dm-multimedia-height', behavior.height);
            $this.attr('data-dm-multimedia-provider', behavior.provider);
            $this.attr('data-dm-multimedia-theme', behavior.theme);
            $this.attr('data-dm-multimedia-volume', behavior.volume);
            $this.attr('data-dm-multimedia-autoPlay', behavior.autoPlay);
            $this.attr('data-dm-multimedia-scaling', behavior.scaling);
            $this.attr('data-dm-multimedia-splash', behavior.splash);
            $this.attr('data-dm-multimedia-title', behavior.title);
            $this.attr('data-dm-multimedia-artist', behavior.artist);
            if (behavior.url) $this.attr('data-dm-multimedia-url', behavior.url);
        },
        stop: function(behavior) {
            var $this = $(this);
            $this.removeAttr('data-dm-multimedia-metadata');
            $this.removeAttr('data-dm-multimedia-width');
            $this.removeAttr('data-dm-multimedia-height');
            $this.removeAttr('data-dm-multimedia-provider');
            $this.removeAttr('data-dm-multimedia-theme');
            $this.removeAttr('data-dm-multimedia-volume');
            $this.removeAttr('data-dm-multimedia-autoPlay');
            $this.removeAttr('data-dm-multimedia-scaling');
            $this.removeAttr('data-dm-multimedia-splash');
            $this.removeAttr('data-dm-multimedia-title');
            $this.removeAttr('data-dm-multimedia-artist');
            $this.removeAttr('data-dm-multimedia-url');
        },
        destroy: function(behavior) {            
            var $this = $(this);
            $this.data('dmMultimediaPluginMetadata', null);
        }
    }
    
    $.fn.dmVideoPlayerMetadataBehavior = function(method, behavior){
        
        return this.each(function() {
            if ( methods[method] ) {
                return methods[ method ].apply( this, [behavior]);
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, [method] );
            } else {
                $.error( 'Method ' +  method + ' does not exist on jQuery.dmVideoPlayerMetadataBehavior' );
            }  
        });
    };

    $.extend($.dm.behaviors, {        
        dmVideoPlayerMetadataBehavior: {
            init: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmVideoPlayerMetadataBehavior('init', behavior);
            },
            start: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmVideoPlayerMetadataBehavior('start', behavior);
            },
            stop: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmVideoPlayerMetadataBehavior('stop', behavior);
            },
            destroy: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmVideoPlayerMetadataBehavior('destroy', behavior);
            }
        }
    });
    
})(jQuery);