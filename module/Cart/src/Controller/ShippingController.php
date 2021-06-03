<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ShippingController extends AbstractActionController
{   

    private $sessionContainer;
    private $customerSessionContainer;

    public function __construct(
        $sessionContainer,
        $customerSessionContainer
    )
    {
        $this->sessionContainer = $sessionContainer;
        $this->customerSessionContainer = $customerSessionContainer;
    }

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
    
        if(!isset($this->customerSessionContainer->user)) {
            $this->sessionContainer->redirectUrl = 'shipping-info';
            return $this->redirect()->toRoute('customer-login');
        }
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
  
        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('viewTemplate', NULL);
        $this->layout($template);

        $viewModel = new ViewModel();

        $viewModel->setTemplate($viewTemplate);
        return $viewModel;
    }


}
