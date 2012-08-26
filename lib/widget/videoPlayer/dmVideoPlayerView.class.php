<?php

/*
 * @author TheCelavi
 */
class dmVideoPlayerView extends dmWidgetPluginView {
    
    public function configure() {
        parent::configure();
        $this->addRequiredVar(array('url'));
    }
    
    protected function doRender() {
        if ($this->isCachable() && $cache = $this->getCache()) {
            return $cache;
        }
        
        $viewVars = $this->getViewVars();
        $videoPlayer = $this->getService('video_player')->url($viewVars['url']);
        
        if (isset ($viewVars['width'])) $videoPlayer->width($viewVars['width']);
        if (isset ($viewVars['height'])) $videoPlayer->height($viewVars['height']);        
        if (isset ($viewVars['provider'])) $videoPlayer->provider($viewVars['provider']);
        if (isset ($viewVars['theme'])) $videoPlayer->theme($viewVars['theme']);
        if (isset ($viewVars['splash'])) $videoPlayer->splash($viewVars['splash']);
        if (isset ($viewVars['volume'])) $videoPlayer->volume($viewVars['volume']);
        if (isset ($viewVars['autoPlay'])) $videoPlayer->autoPlay($viewVars['autoPlay']);
        if (isset ($viewVars['scaling'])) $videoPlayer->scaling($viewVars['scaling']);
        if (isset ($viewVars['id'])) $videoPlayer->id($viewVars['id']);
        if (isset ($viewVars['title'])) $videoPlayer->title($viewVars['title']);
        if (isset ($viewVars['artist'])) $videoPlayer->artist($viewVars['artist']);
        
                
        $html = $videoPlayer->render(); 
        if ($this->isCachable()) {
            $this->setCache($html);
        }
        return $html;
    }
    
}

?>
