<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaryIdea
 *
 * @ORM\Table(name="commentary_idea")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\CommentaryIdeaRepository")
 */
class CommentaryIdea
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
     * @ORM\Column(name="idIdea", type="integer")
     */
    private $idIdea;

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="commentary", type="string", length=255)
     */
    private $commentary;


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
     * Set idIdea
     *
     * @param integer $idIdea
     * @return CommentaryIdea
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

    /**
     * Set idUser
     *
     * @param integer $idUser
     * @return CommentaryIdea
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
     * Set commentary
     *
     * @param string $commentary
     * @return CommentaryIdea
     */
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;

        return $this;
    }

    /**
     * Get commentary
     *
     * @return string 
     */
    public function getCommentary()
    {
        return $this->commentary;
    }
}
