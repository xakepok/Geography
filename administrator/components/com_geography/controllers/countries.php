<?php
use Joomla\CMS\MVC\Controller\AdminController;
defined('_JEXEC') or die;

class GeographyControllerCountries extends AdminController
{
    public function getModel($name = 'Country', $prefix = 'GeographyModel', $config = array())
    {
        return parent::getModel($name, $prefix, array('ignore_request' => true));
    }
}
