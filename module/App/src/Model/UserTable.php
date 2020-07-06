<?php

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Zend\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if(! $row){
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveUser(User $user)
    {
        $data = [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'position' => $user->position,
        ];
        $id = $user->id;

        if(is_null($id)){
            $id = Uuid::uuid4()->toString();
            $data['id'] = $id;
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUser($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update user with identifier %d; does not exist',
                $id
            ));
        }
        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => $id]);
    }
}