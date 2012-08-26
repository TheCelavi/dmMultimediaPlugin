<?php
/**
 * @author TheCelavi
 */
class dmAudioPlayerForm extends dmWidgetPluginForm {

    public function configure() {
        
        $this->widgetSchema['url'] = new sfWidgetFormInputText(array(), array(
            'class'=>'droppable_media'
        ));
        $this->validatorSchema['url'] = new dmValidatorLinkUrl(array(
            'required' => true
        ));
        
        $this->widgetSchema['id'] = new sfWidgetFormInputText();
        $this->validatorSchema['id'] = new dmValidatorCssClasses(array(
            'required'=>false
        ));
        
        $this->widgetSchema['width'] = new sfWidgetFormInputText();
        $this->validatorSchema['width'] = new dmValidatorCssSize(array(
            'required' => true
        )); 
        
        $this->widgetSchema['autoPlay'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['autoPlay'] = new sfValidatorBoolean(array(
            'required' => false
        ));
        
        $this->widgetSchema['loop'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['loop'] = new sfValidatorBoolean(array(
            'required' => false
        ));
        
        $this->widgetSchema['volume'] = new sfWidgetFormInputText();
        $this->validatorSchema['volume'] = new sfValidatorInteger(array(
            'required' => true
        ));
        
        $this->widgetSchema['title'] = new sfWidgetFormInputText();
        $this->validatorSchema['title'] = new sfValidatorString(array(
            'required' => false
        ));

        $this->widgetSchema['artist'] = new sfWidgetFormInputText();
        $this->validatorSchema['artist'] = new sfValidatorString(array(
            'required' => false
        ));
        
        $tmp = sfConfig::get('dm_dmAudioPlayerPlugin_themes');
        $themes = array();
        foreach ($tmp as $key=>$value) $themes[$key] = $value['name'];
        $this->widgetSchema['theme'] = new sfWidgetFormChoice(array(
            'choices' => $this->getI18n()->translateArray($themes)
        ));
        $this->validatorSchema['theme'] = new sfValidatorChoice(array(
            'choices' => array_keys($themes)
        ));
        
        $this->getWidgetSchema()->setLabels(array(
            'url' => 'Audio URL',
            'autoPlay' => 'Auto play'
        ));
        $this->getWidgetSchema()->setHelps(array(
            'url' => 'Supported formats are MP3 and AAC',
        ));
        
        $defaults = $this->getServiceContainer()->getParameter('audio_player.options');
        if (is_null($this->getDefault('width'))) $this->setDefault ('width', $defaults['width']);
        if (is_null($this->getDefault('theme'))) $this->setDefault ('theme', $defaults['theme']);
        if (is_null($this->getDefault('volume'))) $this->setDefault ('volume', $defaults['volume']);
        if (is_null($this->getDefault('loop'))) $this->setDefault ('loop', $defaults['loop']);
        if (is_null($this->getDefault('autoPlay'))) $this->setDefault ('autoPlay', $defaults['autoPlay']);
        parent::configure();
    }

    public function getJavaScripts() {
        return array('dmMultimediaPlugin.audioPlayerForm');
    }

}
