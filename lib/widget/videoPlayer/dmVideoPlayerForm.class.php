<?php

/*
 * @author TheCelavi
 */

class dmVideoPlayerForm extends dmWidgetPluginForm {

    public function configure() {
        
        
        $this->widgetSchema['url'] = new sfWidgetFormInputText(array(), array(
                    'class' => 'droppable_video'
                ));
        $this->validatorSchema['url'] = new dmValidatorLinkUrl(array(
                    'required' => true
                ));
        
        $this->widgetSchema['width'] = new sfWidgetFormInputText();
        $this->validatorSchema['width'] = new sfValidatorInteger(array(
                    'required' => true
                ));

        $this->widgetSchema['height'] = new sfWidgetFormInputText();
        $this->validatorSchema['height'] = new sfValidatorInteger(array(
                    'required' => true
                ));

        $provider = sfConfig::get('dm_dmVideoPlayerPlugin_provider');
        $this->widgetSchema['provider'] = new sfWidgetFormChoice(array(
                    'choices' => $provider
                ));
        $this->validatorSchema['provider'] = new sfValidatorChoice(array(
                    'choices' => array_keys($provider)
                ));

        $tmp = sfConfig::get('dm_dmVideoPlayerPlugin_themes');
        $themes = array();
        foreach ($tmp as $key=>$value) $themes[$key] = $value['name'];
        $this->widgetSchema['theme'] = new sfWidgetFormChoice(array(
                    'choices' => $this->getI18n()->translateArray($themes)
                ));
        $this->validatorSchema['theme'] = new sfValidatorChoice(array(
                    'choices' => array_keys($themes)
                ));

        $this->widgetSchema['volume'] = new sfWidgetFormInputText();
        $this->validatorSchema['volume'] = new sfValidatorInteger(array(
                    'required' => true,
                    'min' => 0,
                    'max' => 100
                ));

        $this->widgetSchema['autoPlay'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['autoPlay'] = new sfValidatorBoolean(array(
                    'required' => false
                ));

        $scaling = sfConfig::get('dm_dmVideoPlayerPlugin_scaling');
        $this->widgetSchema['scaling'] = new sfWidgetFormChoice(array(
                    'choices' => $this->getI18n()->translateArray($scaling)
                ));
        $this->validatorSchema['scaling'] = new sfValidatorChoice(array(
                    'choices' => array_keys($scaling)
                ));

        $this->widgetSchema['splash'] = new sfWidgetFormInputText(array(), array(
                    'class' => 'droppable_image'
                ));
        $this->validatorSchema['splash'] = new dmValidatorLinkUrl(array(
                    'required' => false
                ));
        
        $this->widgetSchema['title'] = new sfWidgetFormInputText();
        $this->validatorSchema['title'] = new sfValidatorString(array(
                    'required' => false
                ));
        
        $this->widgetSchema['artist'] = new sfWidgetFormInputText();
        $this->validatorSchema['artist'] = new sfValidatorString(array(
                    'required' => false
                ));
        
        $this->widgetSchema['id'] = new sfWidgetFormInputText();
        $this->validatorSchema['id'] = new dmValidatorCssClasses(array(
            'required'=>false
        ));
        
        $this->getWidgetSchema()->setLabels(array(
            'url' => 'Video URL',
            'autoPlay' => 'Auto play'
        ));
        $this->getWidgetSchema()->setHelps(array(
            'url' => 'Supported formats are .flv and .fl4',
            'splash' => 'If you add a splash image, video will be played on click'
        ));
        
        $defaults = $this->getServiceContainer()->getParameter('video_player.options');
        if (is_null($this->getDefault('width'))) $this->setDefault ('width', $defaults['width']);
        if (is_null($this->getDefault('height'))) $this->setDefault ('height', $defaults['height']);
        if (is_null($this->getDefault('provider'))) $this->setDefault ('provider', $defaults['provider']);
        if (is_null($this->getDefault('theme'))) $this->setDefault ('theme', $defaults['theme']);
        if (is_null($this->getDefault('volume'))) $this->setDefault ('volume', $defaults['volume']);
        if (is_null($this->getDefault('scaling'))) $this->setDefault ('scaling', $defaults['scaling']);
        if (is_null($this->getDefault('autoPlay'))) $this->setDefault ('autoPlay', $defaults['autoPlay']);        
        parent::configure();
    }

    public function getJavaScripts() {
        return array('dmMultimediaPlugin.videoPlayerForm');
    }

}