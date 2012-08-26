<?php

class dmFlashPlayer extends dmHtmlTag {

    protected 
    $javascripts = array(),
    $stylesheets = array(),
    $quality,
    $scale;
    
    public function __construct($options) {
        $this->quality = sfConfig::get('dm_dmFlashPlayerPlugin_quality');
        $this->scale = sfConfig::get('dm_dmFlashPlayerPlugin_scale');
        $this->initialize($options);
    }

    protected function initialize(array $options = array()) {
        $this->configure($options);
        $this->id(sprintf('flash_player_%s_%s' , dmString::random(), time()));
        $this->play($this->getOption('play'));
        $this->loop($this->getOption('loop'));
        $this->menu($this->getOption('menu'));
        $this->allowFullScreen($this->getOption('allowFullScreen'));
        $this->allowScriptAccess($this->getOption('allowScriptAccess'));
        $this->width($this->getOption('width'));
        $this->height($this->getOption('height'));
        $this->flashVars(array());
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
        if ($value{0} == '.') $value = str_replace ('.', '', $value);
        if ($value != '') return $this->setOption ('id', $value);
        else return $this;
    }

    public function play($value) {
        return $this->setOption('play', ($value)?'true':'false');
    }
    public function autoPlay($value) {
        return $this->play($value);
    }

    public function loop($value) {
        return $this->setOption('loop', ($value)?'true':'false');
    }

    public function menu($value) {
        return $this->setOption('menu', ($value)?'true':'false');
    }
    
    public function allowFullScreen($value) {
        return $this->setOption('allowFullScreen', ($value)?'true':'false');
    }

    public function allowScriptAccess($value) {
        return $this->setOption('allowScriptAccess', ($value)?'true':'false');
    }
    
    public function width($w) {
        if ($w == (int)$w) $w = $w.'px';
        return $this->setOption('width', $w);
    }

    public function height($h) {
        if ($h == (int)$h) $h = $h.'px';
        return $this->setOption('height', $h);
    }

    public function quality($value) {
        if (!isset ($this->quality[$value])) {
            throw new dmException(sprintf('%s is not a valid quality setting. These are : %s', $value, implode(', ', array_keys($this->quality))
            ));
        }
        return $this->setOption('quality', $value);
    }

    public function scale($value) {
        if (!isset ($this->scale[$value])) {
            throw new dmException(sprintf('%s is not a valid scale setting. These are : %s', $value, implode(', ', array_keys($this->scale))
            ));
        }
        return $this->setOption('scale', $value);
    }

    public function base($value) {
        return $this->setOption('base', $value);
    }
    
    public function flashVars(array $vars) {
        return $this->setOption('FlashVars', $this->renderFlashVars($vars));
    }

    public function render() { 
        unset($this->options['class']);
        if ($this->hasOption('base') && trim($this->getOption('base')) == '') unset($this->options['base']);
        $id = $this->getOption('id'); unset($this->options['id']);
        $movie = $this->getOption('url'); unset($this->options['url']);
        $width = $this->getOption('width'); unset($this->options['width']);
        $height = $this->getOption('height'); unset($this->options['height']);
        $params = '';
        $attributes = '';
        
        foreach ($this->options as $key=>$val) {
            $params .= sprintf('<param name="%s" value="%s"></param>', $key, $val);
            $attributes .= sprintf(' %s="%s"', $key, $val);
        }
        
        return sprintf('<object id="%s" name="%s" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="%s" height="%s">
                            <param name="movie" value="%s"></param>
                            %s
                            <embed src="%s" type="application/x-shockwave-flash" width="%s" height="%s" %s></embed>
                        </object>',
                $id,
                $id,                
                $width, 
                $height, 
                $movie, 
                $params,
                $movie,                
                $width, 
                $height,
                $attributes
                );
    }
    
    protected function renderFlashVars(array $vars) {
        if (count($vars) == 0) return '';   
        $result = array();
        foreach ($vars as $key=>$value) $result[] = urlencode($key) . '=' . urlencode($value);
        return implode('&', $result);
    }
    
}
