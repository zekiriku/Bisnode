<?php
namespace App\Controller;


use App\Form\UserForm;
use App\Model\User;
use App\Model\UserTable;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    private $table;

    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function ajaxAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function getUsersJsonAction()
    {
        $users = $this->table->fetchAll();
        $data = [
            'data' => $users->toArray()
        ];
        $view = new JsonModel($data);
        $view->setTerminal(true);
        return $view;
    }

    public function urlAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if($id === 0) {
            return $this->handleUserNotFound($id);
        }
        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            return $this->handleUserNotFound($id);
        }

        $view = new ViewModel([
            'user' => $user
        ]);
        return $this->handleAjaxRequest($view);
    }

    public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        $view = new ViewModel(['form' => $form]);

        if(! $request->isPost()) {
            return $this->handleAjaxRequest($view);
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());


        if(! $form->isValid()){
            return $this->handleInvalidForm($view);
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);

        $flashMessage = sprintf('User : %s %s has been added', $user->firstname, $user->lastname);
        $route = 'user';
        $action = ['action' => 'index'];
        return $this->handleValidForm($flashMessage,$route,$action);

    }

    public function editAction()
    {

        $id = $this->params()->fromRoute('id',0);
        if($id === 0){
            return $this->handleUserNotFound($id);
        }

        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            return $this->handleUserNotFound($id);
        }

        $form = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $view = new ViewModel([
            'id' => $id,
            'form' => $form
        ]);

        if(! $request->isPost()){
            return $this->handleAjaxRequest($view);
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if(! $form->isValid()){
            return $this->handleInvalidForm($view);
        }

        $this->table->saveUser($user);

        $flashMessage = sprintf('User : %s %s has been updated', $user->firstname, $user->lastname);
        $route = 'user';
        $action = ['action' => 'index'];
        return $this->handleValidForm($flashMessage,$route,$action);

    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id',0);
        if($id === 0) {
            return $this->handleUserNotFound($id);
        }
        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            return $this->handleUserNotFound($id);
        }

        $request = $this->getRequest();
        if($request->isPost()){
            $del = $request->getPost('del', 'No');
            if($del === 'Yes'){
                $id = $request->getPost('id');
                $this->table->deleteUser($id);
                $flashMessage = sprintf('User : %s %s has been deleted', $user->firstname, $user->lastname);
            } else {
                $flashMessage = false;
            }
            $route = 'user';
            $action = ['action' => 'index'];
            return $this->handleValidForm($flashMessage,$route,$action);

        }
        $view = new ViewModel([
                'id' => $id,
                'user' => $this->table->getUser($id),
            ]);
        return $this->handleAjaxRequest($view);
    }

    private function handleInvalidForm($view)
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
            $view->setVariable('showBtn', false);
            $this->getResponse()->setStatusCode(400);
        } else {
            $view->setVariable('showBtn', true);
        }
        return $view;

    }

    private function handleValidForm($message, $route, $action)
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $data = [
                'message' => $message
            ];
            $view = new JsonModel($data);
            $view->setTerminal(true);
            return $view;
        } else {
            if($message){
                $this->flashMessenger()->addSuccessMessage($message);
            }
            return $this->redirect()->toRoute($route, $action);
        }
    }

    private function handleUserNotFound($id)
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setReasonPhrase(sprintf('Impossible to find user with id: %s', $id));
            return $response;
        }else{
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
    }

    private function handleAjaxRequest(ViewModel $view){
        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
            $view->setVariable('showBtn', false);
        } else {
            $view->setVariable('showBtn', true);
        }
        return $view;
    }


}