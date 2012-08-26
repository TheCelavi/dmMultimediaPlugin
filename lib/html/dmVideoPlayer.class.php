<?php

/*
 * @author TheCelavi
 */

class dmVideoPlayer extends dmHtmlTag {

    protected 
    $javascripts = array(),
    $stylesheets = array(),
    $themes;
    

    public function __construct($options) {
        $this->themes = sfConfig::get('dm_dmVideoPlayerPlugin_themes');
        $this->initialize($options);        
    }

    protected function initialize(array $options = array()) {
        parent::configure($options);
        $this->javascripts = array(
            'dmMultimediaPlugin.videoPlayerScript',
            'dmMultimediaPlugin.videoPlayerLaunch'
        );
        
        $this->provider($options['provider']);        
        $this->theme($options['theme']);
        $this->scaling($options['scaling']);
        
        $this->id(sprintf('video_player_%s_%s' , dmString::random(), time()));
        $options['title'] = '';
        $options['artist'] = '';
    }

    public function url($url) {
        $resource = dmContext::getInstance()->getServiceContainer()->getService('media_resource')->initialize($url);
        return $this->setOption('url', $resource->getWebPath());
    }

    public function getUrl() {
        return $this->getOption('url');
    }
    
    public function provider($value) {
        $provider = sfConfig::get('dm_dmVideoPlayerPlugin_provider');
        if (array_key_exists($value, $provider)) return $this->setOption('provider', $value);
        else throw new dmException(sprintf('%s is not a valid provider. These are : %s',
              $value,
              implode(', ', array_keys($provider))
        ));
    }

    public function id($value) {
        $value = trim($value);
        if ($value != '') return $this->setOption ('id', ($value{0} != '#') ? '#'.$value : $value);
        else return $this;
    }

    public function title($value) {
        return (trim($value) != '') ? $this->setOption('title', $value) : $this;
    }

    public function artist($value) {
        return (trim($value) != '') ? $this->setOption('artist', $value) : $this;
    }

    public function width($value) {
        return $this->setOption('width', (int) $value);
    }

    public function height($value) {
        return $this->setOption('height', (int) $value);
    }

    public function theme($value) {                
        $themes = array();
        foreach ($this->themes as $key=>$val) $themes[$key] = $val['name']; 
        if (array_key_exists($value, $themes)) return $this->setOption('theme', $value);
        else throw new dmException(sprintf('%s is not a valid theme. These are : %s',
              $value,
              implode(', ', array_keys($themes))
        ));
    }

    public function splash($url) {
        return $this->setOption('splash', $url);
    }

    public function volume($value) {
        return $this->setOption('volume', (int) $value);
    }

    public function autoPlay($value) {
        return $this->setOption('autoPlay',(bool) $value);
    }
    
    public function scaling($value) {
        $scaling = sfConfig::get('dm_dmVideoPlayerPlugin_scaling');
        if (array_key_exists($value, $scaling)) return $this->setOption('scaling', $value);
        else throw new dmException(sprintf('%s is not a valid scaling method. These are : %s',
              $value,
              implode(', ', array_keys($scaling))
        ));
    }
    public function render() {
        $this->loadAssets();
        $title = array();
        if ($this->getOption('title')!='') $title[] = $this->getOption('title');
        if ($this->getOption('artist')!='') $title[] = $this->getOption('artist');
        $helper = dmContext::getInstance()->getServiceContainer()->getService('helper');
        $i18n = dmContext::getInstance()->getServiceContainer()->getService('i18n');
        $html = $helper->open(sprintf('div%s.dmVideoPlayerPlugin', $this->getOption('id')), array(
            'style' => sprintf('width: %spx; height: %spx; display: block', $this->getOption('width'), $this->getOption('height')),
            'title' => implode(' - ', $title),
            'json' => array(
                'player' => $helper->getOtherAssetWebPath('dmMultimediaPlugin.videoPlayer'),
                'url' => $this->getOption('url'),
                'theme' => $this->getOption('theme'),
                'provider' => $this->getOption('provider'),
                'autoPlay' => $this->getOption('autoPlay'),
                'volume' => $this->getOption('volume'),
                'scaling' => $this->getOption('scaling'),
                'tooltips' => array(
                    "play" => $i18n->__("Play"),
                    "pause" => $i18n->__("Pause"),
                    "mute" => $i18n->__("Mute"),	
                    "unmute" => $i18n->__("Unmute"),
                    "stop" => $i18n->__("Stop"),
                    "fullscreen" => $i18n->__("Fullscreen"),
                    "fullscreenExit" => $i18n->__("Exit fullscreen"),
                    "next" => $i18n->__("Next"),	
                    "previous" => $i18n->__("Previous")
                ),
                'controlsUrl' => $helper->getOtherAssetWebPath('dmMultimediaPlugin.videoPlayerControlsPlugin'),
                'rtmpUrl'  => $helper->getOtherAssetWebPath('dmMultimediaPlugin.videoPlayerPseudostreamingPlugin'),
                'pseudostreamingURL' => $helper->getOtherAssetWebPath('dmMultimediaPlugin.videoPlayerRtmpPlugin'),
                'title' => $this->getOption('title'),
                'artist' => $this->getOption('artist')
            )
        ));
        if ($this->hasOption('splash') && $this->getOption('splash') != '') $html .= $this->renderSplash($helper);
        $html .= $helper->close('div');
        return $html;
    }

    
    private function loadAssets() { 
        $response = dmContext::getInstance()->getServiceContainer()->getService('response');
        $response->addJavascript($this->themes[$this->getOption('theme')]['config']);
        foreach ($this->javascripts as $js) $response->addJavascript($js);
        foreach ($this->stylesheets as $css) $response->addStylesheet($css);                
    }
    
    private function renderSplash($helper) {
        $resource = dmContext::getInstance()->getServiceContainer()->getService('media_resource')->initialize($this->getOption('splash'));
        return $helper->media($resource->getSource())
                ->width($this->getOption('width'))
                ->height($this->getOption('height'))
                ->overlay($helper->media($this->themes[$this->getOption('theme')]['image']), 'center')
                ->set('.link');
    }
    
}
