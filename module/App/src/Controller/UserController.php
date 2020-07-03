<?php


namespace App\Controller;


use App\form\UserForm;
use App\Model\User;
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

    public function showAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if($id === 0) {
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        return new ViewModel([
            'user' => $user
        ]);
    }

    public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if(! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());


        if(! $form->isValid()){
            $this->flashMessenger()->addErrorMessage(sprintf('Invalid form'));
            return ['form' => $form];
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
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        $form = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if(! $request->isPost()){
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if(! $form->isValid()){
            return $viewData;
        }
        $this->table->saveUser($user);
        $this->flashMessenger()->addSuccessMessage(sprintf('User : %s %s has been updated', $user->firstname, $user->lastname));
        return $this->redirect()->toRoute('user', ['action' => 'index']);

    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id',0);
        if($id === 0) {
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e){
            $this->flashMessenger()->addErrorMessage(sprintf('Impossible to find user with id: %s', $id));
            return $this->redirect()->toRoute('user', ['action' => 'index']);
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

        return [
            'id' => $id,
            'user' => $this->table->getUser($id),
        ];
    }


}