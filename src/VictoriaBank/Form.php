<?php

namespace Fruitware\VictoriaBankGateway\VictoriaBank;

/**
 * Class Form
 *
 * @package Fruitware\VictoriaBankGateway\VictoriaBank
 */
class Form
{
    const ELEMENT_TEXT   = 'text';
    const ELEMENT_HIDDEN = 'hidden';
    const ELEMENT_SUBMIT = 'submit';
    const ELEMENT_BUTTON = 'button';

    /**
     * @var string
     */
    private $_formName = '';

    /**
     * @var string
     */
    private $_formAction = '';

    /**
     * @var string
     */
    private $_formMethod = 'POST';

    /**
     * @var array
     */
    private $_formElements = [];

    /**
     * Construct
     *
     * @param string $formName
     */
    public function __construct($formName = '')
    {
        if (empty($formName)) {
            $formName = 'form-'.rand();
        }
        $this->_formName = $formName;
        $this->init();

        return $this;
    }

    /**
     * @return $this
     */
    public function init()
    {
        return $this;
    }

    /**
     * Add a text element
     *
     * @param        $elementName
     * @param string $elementValue
     * @param array  $elementOptions
     *
     * @return $this
     */
    public function addTextElement($elementName, $elementValue = '', $elementOptions = [])
    {
        $this->_formElements[$elementName] = $this->_renderElement(self::ELEMENT_TEXT, $elementName, $elementValue, $elementOptions);

        return $this;
    }

    /**
     * @param $type
     * @param $elementName
     * @param $elementValue
     * @param $elementOptions
     *
     * @return string
     */
    protected function _renderElement($type, $elementName, $elementValue, $elementOptions)
    {
        $options = '';
        if (is_array($elementOptions)) {
            foreach ($elementOptions as $name => $value) {
                $options .= ' '.$name.'="'.$value.'"';
            }
        }
        $label = '';
        if ($type != self::ELEMENT_HIDDEN) {
            $label = '&nbsp;<label>'.$elementName.'</label>';
        }

        return '<input type="'.$type.'" name="'.$elementName.'" value="'.$elementValue.'"'.$options.'/>'.$label;
    }

    /**
     * Add a hidden element
     *
     * @param        $elementName
     * @param string $elementValue
     * @param        $elementOptions
     *
     * @return $this
     */
    public function addHiddenElement($elementName, $elementValue = '', $elementOptions = [])
    {
        $this->_formElements[$elementName] = $this->_renderElement(self::ELEMENT_HIDDEN, $elementName, $elementValue, $elementOptions);

        return $this;
    }

    /**
     * @param $action
     *
     * @return $this
     */
    public function setFormAction($action)
    {
        $this->_formAction = $action;

        return $this;
    }

    /**
     * @param $method
     *
     * @return $this
     */
    public function setFormMethod($method)
    {
        $this->_formMethod = $method;

        return $this;
    }

    /**
     * Renders form HTML
     *
     * @param bool $autoSubmit
     *
     * @return string
     */
    public function renderForm($autoSubmit = true)
    {
        $html = '<form id="'.$this->_formName.'-form" name="'.$this->_formName.'" method="'.$this->_formMethod.'" action="'.$this->_formAction.'" enctype="application/x-www-form-urlencoded">'."\n";
        $html .= implode("\n", $this->_formElements)."\n";
        $html .= '</form>';

        return $html;
    }
}
