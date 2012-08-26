<?php
/**
 * @author TheCelavi
 */
class dmAudioPlayerView extends dmWidgetPluginView {

    public function configure() {
        parent::configure();
        $this->addRequiredVar(array('url', 'width'));
    }

    protected function doRender() {
        if ($this->isCachable() && $cache = $this->getCache()) {
            return $cache;
        }
        $viewVars = $this->getViewVars();
        $audioPlayer = $this->getService('audio_player')
                ->url($viewVars['url'])
                ->width($viewVars['width']);
        
        if (isset ($viewVars['theme'])) $audioPlayer->theme($viewVars['theme']);
        if (isset ($viewVars['volume'])) $audioPlayer->volume($viewVars['volume']);
        if (isset ($viewVars['autoPlay'])) $audioPlayer->autoPlay($viewVars['autoPlay']);
        if (isset ($viewVars['id'])) $audioPlayer->id($viewVars['id']);
        if (isset ($viewVars['title'])) $audioPlayer->title($viewVars['title']);
        if (isset ($viewVars['artist'])) $audioPlayer->artist($viewVars['artist']);
        if (isset ($viewVars['loop'])) $audioPlayer->loop($viewVars['loop']);
        
        $html = $audioPlayer->render(); 
        if ($this->isCachable()) {
            $this->setCache($html);
        }
        return $html;
    }
    
}