<?php

namespace App\Model\Entity;

use AbstractEntity;
use Couchbase\Role;

class User extends AbstractEntity
{
    private string $validationKey;
    private bool $valid;
    private string $email;
    private string $firstname;
    private string $lastname;
    private string $password;
    private Role $role;

    /**
     * @return string
     */
    public function getValidationKey(): string
    {
        return $this->validationKey;
    }

    /**
     * @param string $validationKey
     */
    public function setValidationKey(string $validationKey): self
    {
        $this->validationKey = $validationKey;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     */
    public function setValid(bool $valid): self
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }
}