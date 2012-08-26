<?php
/**
 * @author TheCelavi
 */
class dmFlashPlayerForm extends dmWidgetPluginForm {

    public function configure() {
        
        $this->widgetSchema['url'] = new sfWidgetFormInputText(array(), array(
            'class'=>'droppable_media'
        ));
        $this->validatorSchema['url'] = new dmValidatorLinkUrl(array(
                            'required' => true
                        ));
        
        $this->widgetSchema['width'] = new sfWidgetFormInputText();
        $this->validatorSchema['width'] = new dmValidatorCssSize(array(
                    'required' => true
                ));

        $this->widgetSchema['height'] = new sfWidgetFormInputText();
        $this->validatorSchema['height'] = new dmValidatorCssSize(array(
                    'required' => true
                ));
        
        $this->widgetSchema['allowFullScreen'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['allowFullScreen'] = new sfValidatorBoolean(array(
                    'required' => false
                ));        
        
        $this->widgetSchema['allowScriptAccess'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['allowScriptAccess'] = new sfValidatorBoolean(array(
                    'required' => false
                ));        
        
        $this->widgetSchema['id'] = new sfWidgetFormInputText();
        $this->validatorSchema['id'] = new dmValidatorCssClasses(array(
            'required'=>false
        ));
        
        $this->widgetSchema['play'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['play'] = new sfValidatorBoolean(array(
                    'required' => false
                ));
        
        $this->widgetSchema['loop'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['loop'] = new sfValidatorBoolean(array(
                    'required' => false
                ));
        
        $this->widgetSchema['menu'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['menu'] = new sfValidatorBoolean(array(
                    'required' => false
                ));
        
        $quality = sfConfig::get('dm_dmFlashPlayerPlugin_quality');
        $this->widgetSchema['quality'] = new sfWidgetFormChoice(array(
            'choices'=>$quality
        ));
        $this->validatorSchema['quality'] = new sfValidatorChoice(array(
            'choices'=>array_keys($quality)
        ));
        
        $scale = sfConfig::get('dm_dmFlashPlayerPlugin_scale');
        $this->widgetSchema['scale'] = new sfWidgetFormChoice(array(
            'choices'=>$this->getI18n()->translateArray($scale)
        ));
        $this->validatorSchema['scale'] = new sfValidatorChoice(array(
            'choices'=>$this->getI18n()->translateArray(array_keys($scale))
        ));
        
        $this->widgetSchema['base'] = new sfWidgetFormInputText();
        $this->validatorSchema['base'] = new sfValidatorString(array(
                    'required' => false
                ));
        
        $this->widgetSchema['flashVars'] = new sfWidgetFormTextarea();
        $this->validatorSchema['flashVars'] = new dmValidatorYaml(array(
                    'required' => false
                ));
        
        
        $this->getWidgetSchema()->setLabels(array(
            'url' => 'Flash URL',
            'play' => 'Auto play',
            'allowFullScreen'=>'Allow full screen',
            'allowScriptAccess'=>'Allow script access'
        ));
        $this->getWidgetSchema()->setHelps(array(
            'url' => 'Supported format is .swf'
            
        ));
        
        $defaults = $this->getServiceContainer()->getParameter('flash_player.options');
        if (is_null($this->getDefault('width'))) $this->setDefault ('width', $defaults['width']);
        if (is_null($this->getDefault('height'))) $this->setDefault ('height', $defaults['height']);
        if (is_null($this->getDefault('allowFullScreen'))) $this->setDefault ('allowFullScreen', $defaults['allowFullScreen']);
        if (is_null($this->getDefault('allowScriptAccess'))) $this->setDefault ('allowScriptAccess', $defaults['allowScriptAccess']);
        if (is_null($this->getDefault('play'))) $this->setDefault ('play', $defaults['play']);
        if (is_null($this->getDefault('loop'))) $this->setDefault ('loop', $defaults['loop']);
        if (is_null($this->getDefault('menu'))) $this->setDefault ('menu', $defaults['menu']);
        if (is_null($this->getDefault('quality'))) $this->setDefault ('quality', $defaults['quality']);
        if (is_null($this->getDefault('scale'))) $this->setDefault ('scale', $defaults['scale']);
        parent::configure();
    }

    public function getJavaScripts() {
        return array('dmMultimediaPlugin.flashPlayerForm');
    }

}
