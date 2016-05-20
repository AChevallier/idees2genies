<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCommunity
 *
 * @ORM\Table(name="user_community")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserCommunityRepository")
 */
class UserCommunity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idCommunity", type="integer")
     */
    private $idCommunity;

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCommunity
     *
     * @param integer $idCommunity
     * @return UserCommunity
     */
    public function setIdCommunity($idCommunity)
    {
        $this->idCommunity = $idCommunity;

        return $this;
    }

    /**
     * Get idCommunity
     *
     * @return integer 
     */
    public function getIdCommunity()
    {
        return $this->idCommunity;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     * @return UserCommunity
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
