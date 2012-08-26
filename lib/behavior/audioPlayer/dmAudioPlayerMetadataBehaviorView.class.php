<?php
/*
 * @author TheCelavi
 */
class dmAudioPlayerMetadataBehaviorView extends dmBehaviorBaseView {
    public function configure() {
        $this->addRequiredVar(array('width'));
    }
    
    public function filterBehaviorVars(array $vars = array()) {
        $vars = parent::filterBehaviorVars($vars);
        if (isset($vars['url']) && $vars['url'] != '') unset ($vars['url']);
        if (!isset($vars['height'])) {            
            $defaults = dmContext::getInstance()->getServiceContainer()->getParameter('audio_player.options');
            $vars['height'] = $defaults['height'];
        }
        return $vars;
    }
    
    public function getJavascripts() {
        return array(
            'dmMultimediaPlugin.multimediaRenderer',
            'dmMultimediaPlugin.audioPlayerBehaviorLaunch'
        );
    }
}

