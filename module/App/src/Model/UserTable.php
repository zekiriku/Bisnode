<?php

namespace App\Model;

use Ramsey\Uuid\Uuid;
use RuntimeException;
use Zend\Session\SessionManager;
use Zend\Session\Storage\ArrayStorage;

class UserTable
{
    private $users;

    public function __construct()
    {
        $users = $this->getUsers();
        $session = $this->getSession();
        if(!isset($session->userData)){
            $session->userData = $users;
        }
        $this->updateUsersWithSession();
    }

    private function getUsers()
    {
        return [
            new \ArrayObject([
                "id" => "a63cbf1b-c549-4bb2-9d0d-dd76a212de7a",
                "firstname" => "Ronda",
                "lastname" => "Mohamed",
                "email" => "rmohamed0@blinklist.com",
                "position" => "Teacher",
            ]),
            new \ArrayObject([
                "id" => "1e514bfa-7e47-4cdf-a5b6-780f2b048e20",
                "firstname" => "Jeri",
                "lastname" => "O'Lynn",
                "email" => "jolynn1@nbcnews.com",
                "position" => "Professor",
            ]),
            new \ArrayObject([
                "id" => "c2d1df52-5ca7-401b-8212-3686006f7972",
                "firstname" => "Ingaborg",
                "lastname" => "McGuiney",
                "email" => "imcguiney2@businesswire.com",
                "position" => "Marketing Assistant",
            ]),
            new \ArrayObject([
                "id" => "4948089e-376f-42f3-8905-292cc8764dcd",
                "firstname" => "Auroora",
                "lastname" => "Lote",
                "email" => "alote3@unicef.org",
                "position" => "Director of Sales",
            ]),
            new \ArrayObject([
                "id" => "5b805752-32a7-4b2e-a567-2841aa6cd615",
                "firstname" => "Caitlin",
                "lastname" => "Ismay",
                "email" => "cismay4@pcworld.com",
                "position" => "Teacher",
            ]),
            new \ArrayObject([
                "id" => "331350f9-7065-481c-92d4-576c2c6681c5",
                "firstname" => "Tibold",
                "lastname" => "Keinrat",
                "email" => "tkeinrat5@infoseek.co.jp",
                "position" => "Account Coordinator",
            ]),
            new \ArrayObject([
                "id" => "dc4a3e1d-b75a-475e-aefa-df52720fe03b",
                "firstname" => "Cordula",
                "lastname" => "MacKain",
                "email" => "cmackain6@merriam-webster.com",
                "position" => "Project Manager",
            ]),
            new \ArrayObject([
                "id" => "969f3b15-48a1-4fdf-b2be-731216a5f700",
                "firstname" => "Lissie",
                "lastname" => "Parnaby",
                "email" => "lparnaby7@meetup.com",
                "position" => "Account Representative III",
            ]),
            new \ArrayObject([
                "id" => "7f4601b1-03b1-4c8a-b15b-cb0b722c16ac",
                "firstname" => "Velma",
                "lastname" => "Threadgill",
                "email" => "vthreadgill8@gmpg.org",
                "position" => "Quality Engineer",
            ]),
            new \ArrayObject([
                "id" => "6f0cace3-769f-41d8-be0c-0bca2a5c3526",
                "firstname" => "Isidoro",
                "lastname" => "Ramage",
                "email" => "iramage9@google.co.jp",
                "position" => "Internal Auditor",
            ]),
            new \ArrayObject([
                "id" => "558a34be-cbb9-44bd-9604-9ddb412e1d37",
                "firstname" => "Adamo",
                "lastname" => "Secret",
                "email" => "asecreta@wikispaces.com",
                "position" => "Pharmacist",
            ]),
            new \ArrayObject([
                "id" => "9e93c1a8-9ded-4389-9adb-db9d4c35425d",
                "firstname" => "Hyacinthie",
                "lastname" => "McCumskay",
                "email" => "hmccumskayb@plala.or.jp",
                "position" => "Nurse Practicioner",
            ]),
            new \ArrayObject([
                "id" => "9b618633-9b20-4bd7-a706-51e73cbfc071",
                "firstname" => "Jocko",
                "lastname" => "Okill",
                "email" => "jokillc@usnews.com",
                "position" => "Nuclear Power Engineer",
            ]),
            new \ArrayObject([
                "id" => "5aea0c36-801a-4681-86eb-6baf1c701610",
                "firstname" => "Fawne",
                "lastname" => "Spadeck",
                "email" => "fspadeckd@edublogs.org",
                "position" => "Health Coach IV",
            ]),
            new \ArrayObject([
                "id" => "4d9b8c79-97b2-4e35-97f3-e8619f6d55ef",
                "firstname" => "Mona",
                "lastname" => "Tytler",
                "email" => "mtytlere@si.edu",
                "position" => "Senior Developer",
            ]),
            new \ArrayObject([
                "id" => "f6823dfc-d8d8-49d6-8f23-9876ce49d590",
                "firstname" => "Felita",
                "lastname" => "Emmanueli",
                "email" => "femmanuelif@loc.gov",
                "position" => "Senior Developer",
            ]),
            new \ArrayObject([
                "id" => "878406b6-799e-4329-a1c6-ce9d03575728",
                "firstname" => "Archer",
                "lastname" => "Maffin",
                "email" => "amaffing@businessinsider.com",
                "position" => "VP Accounting",
            ]),
            new \ArrayObject([
                "id" => "c61b874a-767f-47d0-a02e-3d56c7ff9784",
                "firstname" => "Alonzo",
                "lastname" => "Aucoate",
                "email" => "aaucoateh@ox.ac.uk",
                "position" => "Engineer III",
            ]),
            new \ArrayObject([
                "id" => "5cd4165a-0ad4-44ed-a0a6-9edc62168f94",
                "firstname" => "Krystal",
                "lastname" => "Quincee",
                "email" => "kquinceei@g.co",
                "position" => "Biostatistician I",
            ]),
            new \ArrayObject([
                "id" => "9bd11a1c-2b36-4619-a7d2-57fac249bb5b",
                "firstname" => "Henrik",
                "lastname" => "Adel",
                "email" => "hadelj@noaa.gov",
                "position" => "Structural Engineer",
            ]),
        ];
    }

    private function getSession()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        return $sessionManager->getStorage();
    }

    private function updateUsersWithSession()
    {
        $this->users = $this->getSession()->userData;
        return;
    }

    public function fetchAll()
    {
        $users = [];
        foreach($this->users as $user){
            $currentUser = new User();
            $currentUser->exchangeArray((array) $user);
            array_push($users, $currentUser);
        }
        return $users;
    }

    public function getUser($id)
    {
        $user = new User();
        $user->exchangeArray((array)$this->users[$this->getUserKey($id)]);
        return $user;

    }

    private function getUserKey($id) {
        $userKey = array_search($id, array_map(function($user){
            return $user['id'];
        }, $this->users));
        if(!$userKey){
            throw new RuntimeException(sprintf(
                'Could not find user with identifier %d',
                $id
            ));
        }
        return $userKey;
    }

    public function saveUser(User $user)
    {
        $data = new \ArrayObject([
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'position' => $user->position,
        ]);

        $id = $user->id;

        if(is_null($id)){
            $id = Uuid::uuid4()->toString();
            $data['id'] = $id;
            $this->insert($data);
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
        $data['id'] = $id;
        $this->update($data);
        return;

    }

    private function insert(\ArrayObject $data)
    {
        array_push($this->users, $data);
        $this->getSession()->userData = $this->users;
        $this->updateUsersWithSession();
        return;
    }

    private function update(\ArrayObject $data)
    {
        $replacement = array($this->getUserKey($data['id']) => $data);
        $usersUpdated = array_replace($this->users, $replacement);
        $this->getSession()->userData = $usersUpdated;
        $this->updateUsersWithSession();
        return;
    }

    public function deleteUser($id)
    {
        unset($this->users[$this->getUserKey($id)]);
        $this->getSession()->userData = $this->users;
        $this->updateUsersWithSession();
        return;
    }
}