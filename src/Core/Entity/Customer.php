<?php

namespace App\Core\Entity;

use App\Core\Exception\ValidateEntityExeption;

class Customer implements EntityInterface
{
    const TYPE = 'customer';
    private $id;
    private $firstName;
    private $lastName;

    public function validate()
    {
        if (empty($this->id) && $this->id !== 0) {
            throw new ValidateEntityExeption('wrong id value');
        }
        if (empty($this->firstName)) {
            throw new ValidateEntityExeption('wrong first name value');
        }
        if (empty($this->lastName)) {
            throw new ValidateEntityExeption('wrong last name value');
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }


}