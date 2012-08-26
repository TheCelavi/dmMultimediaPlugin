var dmVideoPlayer;
if (!dmVideoPlayer) dmVideoPlayer = {};
if (!dmVideoPlayer.skins) dmVideoPlayer.skins = {};
dmVideoPlayer.skins.gray = {    
    "clip": {
        "scaling": "fit",
        "autoPlay": true
    },    
    "screen": {
        "height": "100pct",
        "top": 0
    },
    "plugins": {
        "controls": {
            "stop": false,
            "time": true,
            "mute": true,
            "scrubber": true,
            "volume":true,
            "play": true,
            "borderRadius": "0px",
            "buttonOffColor": "rgba(130,130,130,1)",
            "timeColor": "#ffffff",
            "bufferGradient": "none",
            "sliderColor": "#000000",
            "zIndex": 1,
            "backgroundColor": "rgba(0, 0, 0, 0)",
            "scrubberHeightRatio": 0.6,
            "volumeSliderGradient": "none",
            "tooltipTextColor": "#ffffff",
            "spacing": {
                "time": 6,
                "volume": 8,
                "all": 2
            },
            "sliderGradient": "none",
            "timeBorderRadius": 20,
            "timeBgHeightRatio": 0.8,
            "volumeSliderHeightRatio": 0.6,
            "progressGradient": "none",
            "height": 26,
            "volumeColor": "rgba(163, 163, 163, 1)",
            "tooltips": {
                "marginBottom": 5,
                "buttons": true,
                "play":	"Play",
                "pause": "Pause",
                "mute":	"Mute",	
                "unmute": "Unmute",
                "stop": "Stop",
                "fullscreen": "Fullscreen",
                "fullscreenExit": "Exit fullscreen",
                "next": "Next",	
                "previous": "Previous"
            },
            "timeSeparator": " ",
            "name": "controls",
            "volumeBarHeightRatio": 0.2,
            "opacity": 1,
            "timeFontSize": 12,
            "left": "50pct",
            "tooltipColor": "rgba(0, 0, 0, 0)",
            "border": "0px",
            "volumeSliderColor": "#ffffff",
            "bufferColor": "#a3a3a3",
            "buttonColor": "#ffffff",
            "durationColor": "rgba(128, 128, 128, 1)",
            "autoHide": {
                "enabled": true,
                "hideDelay": 1000,
                "mouseOutDelay": 500,
                "hideStyle": "fade",
                "hideDuration": 500,
                "fullscreenOnly": false
            },
            "backgroundGradient": "none",
            "width": "100pct",
            "sliderBorder": "1px solid rgba(128, 128, 128, 0.7)",
            "display": "block",
            "buttonOverColor": "#ffffff",
            "url": "flowplayer.controls-3.2.5.swf",
            "timeBorder": "0px solid rgba(0, 0, 0, 0.3)",
            "progressColor": "rgba(176, 176, 176, 1)",
            "timeBgColor": "rgb(0, 0, 0, 0)",
            "scrubberBarHeightRatio": 0.2,
            "bottom": 0,
            "builtIn": false,
            "volumeBorder": "1px solid rgba(128, 128, 128, 0.7)",
            "margins": [ 2, 12, 2, 12 ]
        },
        "rtmp": {
        },
        "pseudostreaming" : {
            
        }
    }
}