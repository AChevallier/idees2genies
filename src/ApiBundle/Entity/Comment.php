<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

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
     * @var \DateTime
     *
     * @ORM\Column(name="publicateDate", type="datetime")
     */
    private $publicateDate;


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
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set idIdea
     *
     * @param integer $idIdea
     * @return Comment
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
     * @return Comment
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
     * Set publicateDate
     *
     * @param \DateTime $publicateDate
     * @return Comment
     */
    public function setPublicateDate($publicateDate)
    {
        $this->publicateDate = $publicateDate;

        return $this;
    }

    /**
     * Get publicateDate
     *
     * @return \DateTime 
     */
    public function getPublicateDate()
    {
        return $this->publicateDate;
    }
}
