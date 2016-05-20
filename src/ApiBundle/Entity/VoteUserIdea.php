<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteUserIdea
 *
 * @ORM\Table(name="vote_user_idea")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\VoteUserIdeaRepository")
 */
class VoteUserIdea
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
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="idIdea", type="integer")
     */
    private $idIdea;


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
     * Set idUser
     *
     * @param integer $idUser
     * @return VoteUserIdea
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

    /**
     * Set idIdea
     *
     * @param integer $idIdea
     * @return VoteUserIdea
     */
    public function setIdIdea($idIdea)
    {
        $this->idIdea = $idIdea;

        return $this;
    }

    /**
     * Get idIdea
     *
     * @return integer 
     */
    public function getIdIdea()
    {
        return $this->idIdea;
    }
}
