<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/8/16
 * Time: 2:55 PM
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Verification
 * @package UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_verification")
 * @Vich\Uploadable
 */
class Verification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="verification")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @Vich\UploadableField(mapping="passport_image", fileNameProperty="passport")
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     * @var File $passportFile
     */
    protected $passportFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $passport;

    /**
     * @Vich\UploadableField(mapping="services_image", fileNameProperty="services")
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     * @var File $servicesFile
     */
    protected $servicesFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $services;

    /**
     * @Vich\UploadableField(mapping="document_image", fileNameProperty="document")
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     * @var File $documentFile
     */
    protected $documentFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $document;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $skype;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setPassportFile(File $image = null)
    {
        $this->passportFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getPassportFile()
    {
        return $this->passportFile;
    }

    /**
     * Set passport
     *
     * @param string $passport
     *
     * @return Verification
     */
    public function setPassport($passport)
    {
        $this->passport = $passport;

        return $this;
    }

    /**
     * Get passport
     *
     * @return string
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setServicesFile(File $image = null)
    {
        $this->servicesFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getServicesFile()
    {
        return $this->servicesFile;
    }

    /**
     * Set services
     *
     * @param string $services
     *
     * @return Verification
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return string
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setDocumentFile(File $image = null)
    {
        $this->documentFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * Set document
     *
     * @param string $document
     *
     * @return Verification
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Verification
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Verification
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set skype
     *
     * @param string $skype
     *
     * @return Verification
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return \UserBundle\Entity\User
     */
    public function getSkype()
    {
        return $this->skype;
    }
}
