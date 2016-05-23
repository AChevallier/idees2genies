<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Idea
 *
 * @ORM\Table(name="idea")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\IdeaRepository")
 */
class Idea
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="idea", type="string", length=255)
     */
    private $idea;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="publicateDate", type="datetime")
     */
    private $publicateDate;

    /**
     * @var int
     *
     * @ORM\Column(name="idCommunauty", type="integer", nullable=true)
     */
    private $idCommunauty;

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
     * Set title
     *
     * @param string $title
     * @return Idea
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set idea
     *
     * @param string $idea
     * @return Idea
     */
    public function setIdea($idea)
    {
        $this->idea = $idea;

        return $this;
    }

    /**
     * Get idea
     *
     * @return string 
     */
    public function getIdea()
    {
        return $this->idea;
    }

    /**
     * Set idCommunauty
     *
     * @param integer $idCommunauty
     * @return Idea
     */

    /**
     * Set publicateDate
     *
     * @param DateTime $publicateDate
     * @return User
     */
    public function setPublicateDate($publicateDate)
    {
        $this->publicateDate = $publicateDate;

        return $this;
    }

    /**
     * Get publicateDate
     *
     * @return DateTime
     */
    public function getPublicateDate()
    {
        return $this->publicateDate;
    }

    /**
     * Set idCommunauty
     *
     * @param integer $idCommunauty
     * @return Idea
     */

    public function setIdCommunauty($idCommunauty)
    {
        $this->idCommunauty = $idCommunauty;

        return $this;
    }

    /**
     * Get idCommunauty
     *
     * @return integer 
     */
    public function getIdCommunauty()
    {
        return $this->idCommunauty;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     * @return Idea
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
