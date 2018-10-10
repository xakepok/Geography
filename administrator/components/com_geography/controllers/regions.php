<?php
use Joomla\CMS\MVC\Controller\AdminController;
defined('_JEXEC') or die;

class GeographyControllerRegions extends AdminController
{
    public function getModel($name = 'Region', $prefix = 'GeographyModel', $config = array())
    {
        return parent::getModel($name, $prefix, array('ignore_request' => true));
    }
}
