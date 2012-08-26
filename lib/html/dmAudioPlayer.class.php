<?php

/*
 * @author TheCelavi
 */
class dmAudioPlayer extends dmHtmlTag {
    
    protected 
    $javascripts = array(),
    $stylesheets = array(),
    $themes,
    $flashParams;
    
    public function __construct($options) {
        $this->themes = sfConfig::get('dm_dmAudioPlayerPlugin_themes');
        $this->flashParams = sfConfig::get('dm_dmAudioPlayerPlugin_flashParams');
        $this->flashParams['allowFullScreen'] = ($this->flashParams['allowFullScreen']) ? 'true' : 'false';
        $this->flashParams['allowScriptAccess'] = ($this->flashParams['allowScriptAccess']) ? 'true' : 'false';
        $this->flashParams['menu'] = ($this->flashParams['menu']) ? 'true' : 'false';
        $this->initialize($options);
    }

    protected function initialize(array $options = array()) {
        $this->configure($options);        
        $this->id(sprintf('audio_player_%s_%s' , dmString::random(), time()));
        $options['title'] = '';
        $options['artist'] = '';
        $this->theme($options['theme']); 
    }   

    public function url($url) {     
        $resource = dmContext::getInstance()->getServiceContainer()->getService('media_resource')->initialize($url);        
        return $this->setOption('url', $resource->getWebPath());
    }
    
    public function getUrl() {
        return $this->getOption('url');
    }

    public function id($value) {
        $value = trim($value);
        if ($value != '') return $this->setOption ('id', ($value{0} != '#') ? '#'.$value : $value);
        else return $this;
    }
    
    public function width($w) {
        if ($w == (int)$w) $w = $w.'px';
        return $this->setOption('width', $w);
    }
    
    public function height($h) {
        if ($h == (int)$h) $h = $h.'px';
        return $this->setOption('height', $h);
    }
    
    public function title($value) {        
        return (trim($value) != '') ? $this->setOption('title', $value) : $this;
    }

    public function artist($value) {
        return (trim($value) != '') ? $this->setOption('artist', $value) : $this;
    }
    
    public function autoPlay($value) {
        return $this->setOption('autoPlay',(bool) $value);
    }
    
    public function loop($value) {
        return $this->setOption('loop',(bool) $value);
    }
    
    public function volume($value) {
        return $this->setOption('volume', (int) $value);
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
    
    public function render() {
        $helper = dmContext::getInstance()->getServiceContainer()->getService('helper');
        
        $params = '';
        $attributes = '';  
        
        $theme = $this->themes[$this->getOption('theme')];
        unset($theme['name']);
        
        if ($theme['bgcolor'] == 'transparent' || $theme['bgcolor'] == '') {
            $this->flashParams['wmode'] = 'transparent';
            unset($theme['bgcolor']);
        } else $this->flashParams['wmode'] = 'opaque';
        
        $this->flashParams['FlashVars'] = $theme;
        $this->flashParams['FlashVars']['soundFile'] = $this->getOption('url');
        $this->flashParams['FlashVars']['titles'] = $this->getOption('title');
        $this->flashParams['FlashVars']['artists'] = $this->getOption('artist');
        $this->flashParams['FlashVars']['autostart'] = ($this->getOption('autoPlay')) ? 'yes' : 'no';
        $this->flashParams['FlashVars']['loop'] = ($this->getOption('loop')) ? 'yes' : 'no';
        $this->flashParams['FlashVars']['initialvolume'] = $this->getOption('volume');
        
        $renderedFlashVars = '';
        foreach ($this->flashParams['FlashVars'] as $key=>$value) $result[] = urlencode($key) . '=' . urlencode($value);
        $this->flashParams['FlashVars'] = implode('&', $result);
        
        foreach ($this->flashParams as $key=>$value) {
            $params .= sprintf('<param name="%s" value="%s"></param>', $key, $value);
            $attributes .= sprintf(' %s="%s"', $key, $value);
        }        
        
        return sprintf('<object id="%s" name="%s" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="%s" height="%s">
                            <param name="movie" value="%s"></param>
                            %s
                            <embed src="%s" type="application/x-shockwave-flash" width="%s" height="%s"%s></embed>
                        </object>',
                $this->getOption('id'),
                $this->getOption('id'),
                $this->getOption('width'),
                $this->getOption('height'),
                $helper->getOtherAssetWebPath('dmMultimediaPlugin.audioPlayer'),
                $params,
                $helper->getOtherAssetWebPath('dmMultimediaPlugin.audioPlayer'),
                $this->getOption('width'),
                $this->getOption('height'),
                $attributes);
    }    
}
