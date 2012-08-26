<?php
/**
 * @author TheCelavi
 */
class dmMultimediaActions extends dmFrontBaseActions {
    
    public function executeRenderAjax(dmWebRequest $request) {        
        if (!$request->hasParameter('metadata')) return $this->renderError();
        $content = $this->renderContent($request);  
        if ($content) return $this->renderAsync(array(
            'html' => $content,
            'js' => $this->getResponse()->getJavascripts(),
            'css' => $this->getResponse()->getStylesheets()
        ));
        else return $this->renderAjaxError();
    }
    
    public function executeRenderIFrame(dmWebRequest $request) {
        $response = $this->doHack();
        $html = $this->renderContent($request);
        if ($html) {
            $this->html = $html;
        } else $this->forward ('dmMultimedia', 'renderIFrameError');
    }
    
    public function executeRenderText(dmWebRequest $request) {
        $html = $this->renderContent($request);
        if ($html) return $this->renderText ($html);
        else $this->forward ('dmMultimedia', 'renderTextError');
    }
    
    public function renderAjaxError() {
        return array(
            'error' => true,
            'html' => $this->renderPartial('dmMultimedia/error'), // TODO? Some HTML content?
            'js' => $this->getResponse()->getJavascripts(),
            'css' => $this->getResponse()->getStylesheets()
        );
    }
    
    public function executeRenderIFrameError() {
        $this->doHack();
    }
    
    public function executeRenderTextError(dmWebRequest $request) {
        $this->setLayout(false);
        $this->setTemplate(false);
        return $this->renderPartial('dmMultimedia/error');
    }

    protected function doHack() {
        $this->setLayout(sfConfig::get('sf_plugins_dir') . '/dmMultimediaPlugin/modules/dmMultimedia/templates/layout');
        $context = dmContext::getInstance();
        $page = new DmPage();
        $page->setAction('render')->setModule('dmMultimediaPlugin')->setTitle($this->getI18n()->__('Media preview'));
        $context->setPage($page); // It will throw an error if we do not do this...
        $response = dmContext::getInstance()->getResponse();
        $response->clearStylesheets()->clearJavascripts();
        $response->addStylesheet('dmMultimediaPlugin.renderer');
        return $response;
    }

    protected function renderContent(dmWebRequest $request) {
        if (!$request->hasParameter('metadata')) return false;
        $bool = new sfValidatorBoolean(); // Only one instance is required for cleaning :) optimization...
        $html = '';
        try {
            switch ($request->getParameter('metadata')) {
                case 'embedded_video': {
                    $helper = $this->getService('embedded_video')->url($request->getParameter('url'));
                    if ($request->hasParameter('width') && $request->getParameter('width') != '') $helper->width((int) $request->getParameter('width'));
                    if ($request->hasParameter('height') && $request->getParameter('height') != '') $helper->height((int) $request->getParameter('height'));
                    $html = $helper->render();
                } break;
                case 'audio_player': {
                    $helper = $this->getService('audio_player')->url($request->getParameter('url'));
                    if ($request->hasParameter('width') && $request->getParameter('width') != '') $helper->width((int) $request->getParameter('width'));
                    if ($request->hasParameter('height') && $request->getParameter('height') != '') $helper->height((int) $request->getParameter('height'));
                    if ($request->hasParameter('title') && $request->getParameter('title') != '') $helper->title($request->getParameter('title'));
                    if ($request->hasParameter('artist') && $request->getParameter('artist') != '') $helper->artist($request->getParameter('artist'));
                    if ($request->hasParameter('autoPlay') && $request->getParameter('autoPlay') != '') $helper->autoPlay($bool->clean($request->getParameter('autoPlay')));
                    if ($request->hasParameter('loop') && $request->getParameter('loop') != '') $helper->loop($bool->clean($request->getParameter('loop')));
                    if ($request->hasParameter('volume') && $request->getParameter('volume') != '') $helper->volume((int) $request->getParameter('volume'));
                    if ($request->hasParameter('theme') && $request->getParameter('theme') != '') $helper->theme($request->getParameter('theme'));
                    $html = $helper->render();
                } break;
                case 'flash_player': {
                    $helper = $this->getService('flash_player')->url($request->getParameter('url'));
                    if ($request->hasParameter('width') && $request->getParameter('width') != '') $helper->width((int) $request->getParameter('width'));
                    if ($request->hasParameter('height') && $request->getParameter('height') != '') $helper->height((int) $request->getParameter('height'));
                    if ($request->hasParameter('autoPlay') && $request->getParameter('autoPlay') != '') $helper->autoPlay($bool->clean($request->getParameter('autoPlay')));
                    if ($request->hasParameter('loop') && $request->getParameter('loop') != '') $helper->loop($bool->clean($request->getParameter('loop')));
                    if ($request->hasParameter('menu') && $request->getParameter('menu') != '') $helper->menu($bool->clean($request->getParameter('menu')));
                    if ($request->hasParameter('allowFullScreen') && $request->getParameter('allowFullScreen') != '') $helper->allowFullScreen($bool->clean($request->getParameter('allowFullScreen')));
                    if ($request->hasParameter('allowScriptAccess') && $request->getParameter('allowScriptAccess') != '') $helper->allowScriptAccess($bool->clean($request->getParameter('allowScriptAccess')));
                    if ($request->hasParameter('quality') && $request->getParameter('quality') != '') $helper->quality($request->getParameter('quality'));
                    if ($request->hasParameter('scale') && $request->getParameter('scale') != '') $helper->scale($request->getParameter('scale'));
                    if ($request->hasParameter('base') && $request->getParameter('base') != '') $helper->base($request->getParameter('base'));
                    if ($request->hasParameter('flashVars') && $request->getParameter('flashVars') != '') $helper->flashVars($request->getParameter('flashVars'));
                    $html = $helper->render();
                } break;
                case 'video_player': {
                    $response = dmContext::getInstance()->getResponse();
                    $response->addJavascript('lib.jquery');
                    $response->addJavascript('lib.metadata');
                    $response->addJavascript('dmMultimediaPlugin.videoPlayerLaunch');                    
                    $helper = $this->getService('video_player')->url($request->getParameter('url'));
                    if ($request->hasParameter('width') && $request->getParameter('width') != '') $helper->width((int) $request->getParameter('width'));
                    if ($request->hasParameter('height') && $request->getParameter('height') != '') $helper->height((int) $request->getParameter('height'));
                    if ($request->hasParameter('provider') && $request->getParameter('provider') != '') $helper->provider($request->getParameter('provider'));
                    if ($request->hasParameter('title') && $request->getParameter('title') != '') $helper->title($request->getParameter('title'));
                    if ($request->hasParameter('artist') && $request->getParameter('artist') != '') $helper->artist($request->getParameter('artist'));
                    if ($request->hasParameter('theme') && $request->getParameter('theme') != '') $helper->theme($request->getParameter('theme'));
                    if ($request->hasParameter('splash') && $request->getParameter('splash') != '') $helper->splash($request->getParameter('splash'));
                    if ($request->hasParameter('volume') && $request->getParameter('volume') != '') $helper->volume((int) $request->getParameter('volume'));
                    if ($request->hasParameter('autoPlay') && $request->getParameter('autoPlay') != '') $helper->autoPlay($bool->clean($request->getParameter('autoPlay')));
                    if ($request->hasParameter('scaling') && $request->getParameter('scaling') != '') $helper->scaling($request->getParameter('scaling'));
                    $html = $helper->render();
                    $response->addJavascript('dmMultimediaPlugin.multimediaRenderer');
                } break;
                case 'image': {
                    $helper = $this->getHelper()->media($request->getParameter('url'));
                    if ($request->hasParameter('width') && $request->getParameter('width') != '') $helper->width((int) $request->getParameter('width'));
                    if ($request->hasParameter('height') && $request->getParameter('height') != '') $helper->height((int) $request->getParameter('height'));
                    if ($request->hasParameter('alt') && $request->getParameter('alt') != '') $helper->alt($request->getParameter('alt'));
                    if ($request->hasParameter('method') && $request->getParameter('method') != '') $helper->method($request->getParameter('method'));
                    if ($request->hasParameter('quality') && $request->getParameter('quality') != '') $helper->quality((int) $request->getParameter('quality'));
                    $html = $helper->render();
                } break;
                default: {
                    return false;
                }
            }
        } catch (Exception $e) {
            return false;
        }
        return $html;
    }
    
}

