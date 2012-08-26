<?php
/*
 * @author TheCelavi
 */
class dmVideoPlayerMetadataBehaviorView extends dmBehaviorBaseView {
    public function configure() {
        $this->addRequiredVar(array('width', 'height'));
    }
    
    public function filterBehaviorVars(array $vars = array()) {
        $vars = parent::filterBehaviorVars($vars);
        if (isset($vars['url']) && $vars['url'] != '') $vars['url'] = $this->getService('video_player')->url($vars['url'])->getUrl();
        elseif (isset($vars['url'])) unset ($vars['url']);
        return $vars;
    }
    
    public function getJavascripts() {
        return array(
            'dmMultimediaPlugin.multimediaRenderer',
            'dmMultimediaPlugin.videoPlayerBehaviorLaunch'
        );
    }
}


