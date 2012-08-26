(function($){
    function initializeDmVideoPlayer($context) {
        var $videoPlayers = $context.find('.dmVideoPlayerPlugin');
        $.each($videoPlayers, function(){
            var settings = $videoPlayers.metadata();
            var theme = $.extend({}, dmVideoPlayer.skins[settings.theme]);
            theme.clip.autoPlay = settings.autoPlay;
            theme.clip.scaling = settings.scaling;
            theme.plugins.tooltips = $.extend(theme.plugins.tooltips, settings.tooltips);
            theme.plugins.controls.url = settings.controlsUrl;
            switch (settings.provider) {
                case 'pseudostreaming': {
                        theme.clip.provider = 'pseudostreaming';
                        theme.plugins.pseudostreaming.url = settings.pseudostreamingURL;
                        theme.clip.url = settings.url; 
                }break;
                case 'rtmp' : {
                        theme.clip.provider = 'rtmp';
                        theme.plugins.rtmp.url = settings.rtmpUrl;
                        theme.plugins.rmtp.netConnectionUrl = settings.url;
                } break;
                default: {
                        theme.clip.url = settings.url; 
                } break;
            }
            $(this).flowplayer(settings.player, theme);
            $f().onStart(function() {
                this.setVolume(settings.volume);                
            });
        });
    }
    $('#dm_page div.dm_widget').bind('dmWidgetLaunch', function() {
        initializeDmVideoPlayer($(this));
    });
    $(function(){
        initializeDmVideoPlayer($('#dm_admin_content'));
    });
})(jQuery);