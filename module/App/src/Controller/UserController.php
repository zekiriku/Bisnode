<?php


namespace App\Controller;


use App\form\UserForm;
use App\Model\User;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    private $table;

    public function __construct($table)
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
            return $this->handleAjaxRequest($view);
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        $this->flashMessenger()->addSuccessMessage(sprintf('User : %s %s has been added', $user->firstname, $user->lastname));
        return $this->redirect()->toRoute('user', ['action' => 'index']);

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
            return $this->handleAjaxRequest($view);
        }

        $this->table->saveUser($user);
        $this->flashMessenger()->addSuccessMessage(sprintf('User : %s %s has been updated', $user->firstname, $user->lastname));
        return $this->redirect()->toRoute('user', ['action' => 'index']);

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
            }
            $this->flashMessenger()->addSuccessMessage(sprintf('User : %s %s has been deleted', $user->firstname, $user->lastname));

            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        $view = new ViewModel([
                'id' => $id,
                'user' => $this->table->getUser($id),
            ]);
        return $this->handleAjaxRequest($view);
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