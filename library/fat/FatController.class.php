<?php

class FatController extends stdClass
{
    protected $_modelName;
    protected $_controllerName;
    protected $_actionName;
    protected $_template;
    protected $siteLangId;

    protected $_autoCreateModel = true;

    public function __construct($action)
    {
        $this->_controllerName = get_class($this);
        $this->_modelName = substr($this->_controllerName, 0, (strlen($this->_controllerName)) - strlen('Controller'));
        $this->_actionName = $action;

        $model = $this->_modelName;

        if ($this->_autoCreateModel) {
            if (file_exists(CONF_APPLICATION_PATH . 'models/' . strtolower($this->_modelName) . '.php')) {
                $this->$model = new $model();
            } else {
                $this->$model = new FatModel();
            }
        }

        $this->_template = new FatTemplate($this->_controllerName, $this->_actionName);
    }

    public function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    public function get($name)
    {
        return $this->_template->get($name);
    }
}
