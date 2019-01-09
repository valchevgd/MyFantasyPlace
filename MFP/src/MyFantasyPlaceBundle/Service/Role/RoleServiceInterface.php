<?php

namespace MyFantasyPlaceBundle\Service\Role;


use MyFantasyPlaceBundle\Entity\Role;

interface RoleServiceInterface
{
    /**
     * @param string $role
     * @return Role
     */
    public function getRole(string $role);
}