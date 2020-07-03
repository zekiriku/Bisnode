<?php
namespace App\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AppController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}