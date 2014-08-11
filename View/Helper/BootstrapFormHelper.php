<?php

App::uses('Bs3FormHelper', 'Bs3Helpers.View/Helper');

class BootstrapFormHelper extends Bs3FormHelper {

    /**
     * Overrides parent method end, adding Bootstrap styles to submit button.
     *
     * @param string|array $options as a string will use $options as the value of button,
     * @return string a closing FORM tag optional submit button.
     */
	public function end($options = null, $secureAttributes = array()) {
        if ($options !== null) {
            if (!is_array($options)) {
                $options = array('label' => $options);
            }
            if (!isset($options['class'])) {
                $options['class'] = 'btn btn-default';
            }
        }

        return parent::end($options, $secureAttributes);
    }

}