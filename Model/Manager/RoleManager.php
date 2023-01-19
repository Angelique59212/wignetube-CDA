<?php

namespace App\Model\Manager;

use App\Model\Entity\Role;
use App\Model\Entity\User;
use Connect;

class RoleManager
{
    public const TABLE = 'mdf58_role';
    public const ROLE_USER = 'user';

    public static function getAll(): array
    {
        $role = [];
        $query = Connect::dbConnect()->query("SELECT * FROM " . self::TABLE);
        if ($query) {
            foreach ($query->fetchAll() as $roleData) {
                $role[] = (new Role())
                    ->setId($roleData['id'])
                    ->setRoleName($roleData['role_name']);
            }
        }
        return $role;
    }

    /**
     * @param User $user
     * @return array
     */
    public static function getRoleByUser(User $user) : array
    {
        $role = [];
        $roleId = Connect::dbConnect()->query("
            SELECT * FROM " . UserManager::TABLE . "WHERE id IN (SELECT mdf58_role_fk FROM " . self::TABLE . " WHERE user_fk =  {user->getId()})
            ");
        if ($roleId) {
            foreach ($roleId->fetchAll() as $roleData) {
                $role[] = (new Role())
                    ->setId($roleData['id'])
                    ->setRoleName($roleData['role_name']);
            }
        }
        return $role;
    }


    /**
     * @param string $roleName
     * @return Role
     */
    public static function getRoleByName(string $roleName) : Role
    {
        $role = new Role();
        $rQuery = Connect::dbConnect()->query("
            SELECT * FROM " . self::TABLE . " WHERE role_name = '".$roleName."'
        ");
        if ($rQuery && $roleData = $rQuery->fetch()) {
            $role->setId($roleData['id']);
            $role->setRoleName($roleData['role_name']);
        }
        return $role;
    }

    /**
     * @return Role
     */
    public static function getDefaultRole(): Role
    {
        return self::getRoleByName('user');
    }
}
