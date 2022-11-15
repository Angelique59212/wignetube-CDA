<?php

namespace App\Model\Manager;

use App\Model\Entity\User;

use Connect;
use Exception;

class UserManager
{
    public const TABLE = 'mdf58_user';
    public const RESET_PASSWORD_TABLE = 'mdf58_resetpassword';


    /**
     * @return array
     */
    public static function getAll(): array
    {
        $users = [];
        $result = Connect::dbConnect()->query("SELECT * FROM " . self::TABLE);

        if ($result) {
            foreach ($result->fetchAll() as $data) {
                $users[] = self::makeUser($data);
            }
        }
        return $users;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function validUser(int $id) : bool
    {
        $stmt = Connect::dbConnect()->prepare("
        UPDATE " . self::TABLE . "SET valid = :valid WHERE id = $id
        ");
        $stmt->bindValue(':valid', true);

        return $stmt->execute();
    }

    /**
     * @param array $data
     * @return User
     */
    private static function makeUser(array $data) : User
    {
        $user = (new User())
            ->setId($data['id'])
            ->setValidationKey($data['validation_key'])
            ->setValid($data['valid'])
            ->setEmail($data['email'])
            ->setFirstname($data['firstname'])
            ->setLastname($data('lastname'))
            ->setPassword($data['password']);
        return $user->setRole(RoleManager::getRoleByUser($user));
    }

    /**
     * @param int $id
     * @return User|null
     */
    public static function getUserById(int $id) : ?User
    {
        $result = Connect::dbConnect()->query("SELECT * FROM " .self::TABLE . "WHERE id = $id ");
        return $result ? self::makeUser($result->fetch()) : null;
    }

    /**
     * @param string $mail
     * @return bool
     */
    public static function mailExists(string $mail): bool
    {
        $result = Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE email = \"$mail\"");
        return $result ? $result->fetch()['cnt'] : 0;
    }


    /**
     * @param int $id
     * @return bool
     */
    public static function userExists(int $id) : bool
    {
        $result = Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . "WHERE id = $id");
        return $result ? $result->fetch()['cnt'] : 0;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function addUser(User &$user): bool
    {
        $stmt = Connect::dbConnect()->prepare("
            INSERt INTO ". self::TABLE . " (validation_key, email, firstname, lastname, password, role_fk)
            VALUES (:validation_key, :email, :firstname, :lastname, :password, :role_fk)
        ");

        $stmt->bindValue(':validation_key', $user->getValidationKey());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':firstname', $user->getFirstname());
        $stmt->bindValue(':lastname', $user->getLastname());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':role_fk', $user->getRole()->getId());

        $result = $stmt->execute();
        $user->setId(Connect::dbConnect()->lastInsertId());

        return $result;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function deleteUser(User $user) : bool
    {
        if (self::userExists($user->getId())) {
            return Connect::dbConnect()->exec("
                DELETE FROM " . self::TABLE . " WHERE id = {$user->getId()}            
            ");
        }
        return false;
    }

    /**
     * @param int $id
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string|null $password
     * @return void
     */
    public static function editUser(int $id, string $firstname, string $lastname, string $email, string $password = null)
    {
        $passwordField = null !== $password ? ', password=:password' : '';
        $stmt = Connect::dbConnect()->prepare("
            UPDATE " . self::TABLE .
            "SET firstname = :firstname, lastname = :lastname, email = :email" .$passwordField .
            "WHERE id = $id
        ");
        $stmt->bindValue(':firstname' , $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        if (null !== $password) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->execute();
    }

    /**
     * @param string $mail
     * @return User|null
     */
    public static function getUserByMail(string $mail) : ?User
    {
        $stmt = Connect::dbConnect()->prepare("SELECT * FROM " . self::TABLE . " WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $email);
        $result = $stmt->execute();
        if ($result && $data = $stmt->fetch()) {
            return self::makeUser($data);
        }
        return null;
    }

    /**
     * @param string $email
     * @param string $token
     * @return bool
     * @throws Exception
     */
    public static function addUserResetPasswordEntry(string $email, string $token) : bool
    {
        $date = new \DateTime('now' , new \DateTimeZone('Europe/Paris'));

        $stmt = Connect::dbConnect()->prepare("
            INSERT INTO " . self::RESET_PASSWORD_TABLE." (email,token,date_add)
                VALUES(:email, :token, :date_add)
        ");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam('token', $token);
        $stmt->bindValue('date_add', $date->format('Y-m-d H:i:s'));

        return $stmt->execute();
    }

    /**
     * Delete expired password reset request token.
     * @param string $mail
     * @param string $token
     * @return void
     */
    public static function deleteUserResetPasswordEntry(string $mail, string $token)
    {

    }

    public static function getResetPasswordTokenData(string $token): ?array
    {
        $stmt = Connect::dbConnect()->prepare("
            SELECT * FROM " . self::RESET_PASSWORD_TABLE." WHERE token =:token
        ");

        $stmt->bindParam(':token', $token);
        $result = $stmt->execute();
        if ($result && $data = $stmt->fetch()) {
            return $data;
        }
        return null;
    }
}