<?php
/**
 * @author TheCelavi
 */
class dmEmbeddedVideoView extends dmWidgetPluginView {

    public function configure() {
        parent::configure();
        $this->addRequiredVar(array('url'));
    }

    protected function doRender() {
        if ($this->isCachable() && $cache = $this->getCache()) {
            return $cache;
        }
        $viewVars = $this->getViewVars();
        $video = $this->getService('embedded_video')->url($viewVars['url']);
        if (isset ($viewVars['id'])) $video->id($viewVars['id']);
        if (isset ($viewVars['width'])) $video->width($viewVars['width']);
        if (isset ($viewVars['height'])) $video->height($viewVars['height']);
        if (isset ($viewVars['id'])) $video->id($viewVars['id']);
        $html = $video->render(); 
        if ($this->isCachable()) {
            $this->setCache($html);
        }
        return $html;
    }
    
}
