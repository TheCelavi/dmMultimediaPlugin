<?php
/*
 * @author TheCelavi
 */
class dmEmbeddedVideoMetadataBehaviorForm extends dmBehaviorBaseForm {
    public function configure() {
        $this->widgetSchema['inner_target'] = new sfWidgetFormInputText();
        $this->validatorSchema['inner_target'] = new sfValidatorString(array(
            'required' => false
        ));
        
        $this->widgetSchema['url'] = new sfWidgetFormInputText();
        $this->validatorSchema['url'] = new sfValidatorAnd(
                    array(
                        new sfValidatorUrl(array(
                            'required'=> false
                        )),
                        new sfValidatorOr(
                            array(                                
                                new sfValidatorRegex(array('pattern' => '/youtube.com/i')),
                                new sfValidatorRegex(array('pattern' => '/vimeo.com/i')),
                                new sfValidatorRegex(array('pattern' => '/dailymotion.com/i'))
                            )    
                        )
                    ), array('required' => false)
                );
        $this->getValidator('url')->setMessage('invalid','Only YouTube, Vimeo and Dailymotion are supported.');
        
        $this->widgetSchema['width'] = new sfWidgetFormInputText();
        $this->validatorSchema['width'] = new sfValidatorInteger(array(
                    'required' => true,
                    'min' => 100
                ));

        $this->widgetSchema['height'] = new sfWidgetFormInputText();
        $this->validatorSchema['height'] = new sfValidatorInteger(array(
                    'required' => true,
                    'min' => 100
                ));
        
        $this->getWidgetSchema()->setLabels(array(
            'url' => 'Video URL'
        ));
        $this->getWidgetSchema()->setHelps(array(
            'url' => 'Copy/paste URL from the address bar of the browser, or behavior will try to find out the link from the URL, if there is one near',
        ));
        
        if (is_null($this->getDefault('inner_target'))) $this->setDefault ('inner_target', 'a');
        $defaults = $this->getServiceContainer()->getParameter('embedded_video.options');        
        if (is_null($this->getDefault('width'))) $this->setDefault ('width', $defaults['width']);
        if (is_null($this->getDefault('height'))) $this->setDefault ('height', $defaults['height']);        
        parent::configure();
    }
}

