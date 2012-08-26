<?php
/**
 * @author TheCelavi
 */
class dmEmbeddedVideo extends dmHtmlTag {
    
    protected 
    $javascripts = array(),
    $stylesheets = array();
    
    public function __construct($options) {
        $this->initialize($options);
    }
    
    protected function initialize(array $options = array()) {
        $this->configure($options);
        $this->id(sprintf('dm_embedded_video_%s_%s' , dmString::random(), time()));
    }
    
    public function id($value) {
        $value = trim($value);
        if ($value != '') return $this->setOption ('id', ($value{0} != '#') ? $value : str_replace('#', '', $value));
        else return $this;
    }

    public function width($w) {
        return $this->setOption('width', (int)$w);
    }

    public function height($h) {
        return $this->setOption('height', (int)$h);
    }
    
    public function url($url) {
        if (strpos($url, 'youtube.com'))
            $url = sprintf('http://www.youtube.com/v/%s&fs=1', preg_replace('|^' . preg_quote('http://www.youtube.com/watch?v=', '|') . '(.+)$|', '$1', $url));
        elseif (strpos($url, 'vimeo.com'))
            $url = sprintf('http://vimeo.com/moogaloop.swf?clip_id=%s&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1', preg_replace('|^' . preg_quote('http://vimeo.com/', '|') . '(\d+)$|', '$1', $url));
        elseif (strpos($url, 'dailymotion.com'))
            $url = str_replace('/video/', '/swf/video/', $url);
        else $url = '';
        if ($url == '') throw new dmException(sprintf('%s is not supported video service. These are : %s',
              $url,
              implode(', ', array('YouTube', 'Vimeo', 'Dailymotion'))
        ));
        return $this->setOption('url', $url);
    }
    
    public function getUrl() {
        return $this->getOption('url');
    }
    
    public function render() {
        $afs = ($this->getOption('allowFullScreen')) ? 'true' : 'false';
        $asa = ($this->getOption('allowScriptAccess')) ? 'true' : 'false';
        $id = sprintf('id="%s" name="%s"',$this->getOption('id'), $this->getOption('id'));
        return sprintf('<object %s classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="%s" height="%s">
                            <param name="movie" value="%s"></param>
                            <param name="allowFullScreen" value="%s"></param>
                            <param name="allowScriptAccess" value="%s"></param>
                            <embed src="%s" type="application/x-shockwave-flash" allowfullscreen="%s" allowscriptaccess="%s" width="%s" height="%s"></embed>
                            </object>', $id, $this->getOption('width'), $this->getOption('height'), $this->getOption('url'), $afs, $asa, $this->getOption('url'), $afs, $asa, $this->getOption('width'), $this->getOption('height'));
    }

}

