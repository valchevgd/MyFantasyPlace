<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 1/8/2019
 * Time: 1:36 PM
 */

namespace MyFantasyPlaceBundle\Service\Role;


use MyFantasyPlaceBundle\Repository\RoleRepository;

class RoleService implements RoleServiceInterface
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleService constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }


    public function getRole(string $role)
    {
        return $this->roleRepository->findOneBy(['name' => $role]);
    }
}