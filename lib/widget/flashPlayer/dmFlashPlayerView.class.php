<?php

/**
 *
 * @author TheCelavi
 */
class dmFlashPlayerView extends dmWidgetPluginView {

    public function configure() {
        parent::configure();
        $this->addRequiredVar(array('url'));
    }

    protected function doRender() {
        if ($this->isCachable() && $cache = $this->getCache()) {
            return $cache;
        }
        $viewVars = $this->getViewVars();
        $viewVars['flashVars'] = (isset($viewVars['flashVars']) && $viewVars['flashVars']!='' && is_array($vars = sfYaml::load($viewVars['flashVars']))) ? $vars : array(); 
        $flashPlayer = $this->getService('flash_player')->url($viewVars['url'])->flashVars($viewVars['flashVars']);
        
        if (isset ($viewVars['width'])) $flashPlayer->width($viewVars['width']);
        if (isset ($viewVars['height'])) $flashPlayer->height($viewVars['height']);
        if (isset ($viewVars['allowFullScreen'])) $flashPlayer->allowFullScreen($viewVars['allowFullScreen']);
        if (isset ($viewVars['allowScriptAccess'])) $flashPlayer->allowScriptAccess($viewVars['allowScriptAccess']);
        if (isset ($viewVars['play'])) $flashPlayer->play($viewVars['play']);
        if (isset ($viewVars['loop'])) $flashPlayer->loop($viewVars['loop']);
        if (isset ($viewVars['id'])) $flashPlayer->id($viewVars['id']);
        if (isset ($viewVars['menu'])) $flashPlayer->menu($viewVars['menu']);
        if (isset ($viewVars['quality'])) $flashPlayer->quality($viewVars['quality']);
        if (isset ($viewVars['scale'])) $flashPlayer->scale($viewVars['scale']);
        if (isset ($viewVars['base'])) $flashPlayer->base($viewVars['base']);

        $html = $flashPlayer->render(); 
        if ($this->isCachable()) {
            $this->setCache($html);
        }
        return $html;
    }
}

?>
