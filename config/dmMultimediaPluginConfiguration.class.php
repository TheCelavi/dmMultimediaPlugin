<?php
/**
 * @author TheCelavi
 */
class dmMultimediaPluginConfiguration extends sfPluginConfiguration {
    
    public function initialize() {
        $this->dispatcher->connect('dm.context.loaded', array($this, 'listenToContextLoadedEvent'));
    }

    public function listenToContextLoadedEvent(sfEvent $e) {
        dmProjectConfiguration::getActive()->loadHelpers('Multimedia');
    }
}
