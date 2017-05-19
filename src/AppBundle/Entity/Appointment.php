<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppointmentRepository")
 */
class Appointment
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="startAt", type="date")
     *
     * @var \DateTime
     */
    private $startAt;

    /**
     * @ORM\Column(name="reference", type="string", length=14, unique=true)
     *
     * @var string
     */
    private $reference;

    /**
     * @ORM\Column(name="isPaid", type="boolean")
     *
     * @var bool
     */
    private $isPaid;

    /**
     * @ORM\ManyToOne(targetEntity="Animal", inversedBy="appointments")
     *
     * @var Animal
     */
    private $animal;

    /**
     * @ORM\ManyToOne(targetEntity="Disease", inversedBy="appointments")
     *
     * @var Disease
     */
    private $disease;

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
     * Set startAt
     *
     * @param \DateTime $startAt
     * @return Appointment
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Appointment
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set isPaid
     *
     * @param boolean $isPaid
     * @return Appointment
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    /**
     * Get isPaid
     *
     * @return boolean
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set the animal.
     *
     * @param Animal $animal
     *
     * @return Appointment
     */
    public function setAnimal(Animal $animal)
    {
        if ($this->animal !== $animal) {
            $this->animal = $animal;
        }

        return $this;
    }

    /**
     * Get the animal.
     *
     * @return Animal
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Set the disease.
     *
     * @param Disease $disease
     *
     * @return Appointment
     */
    public function setDisease(Disease $disease)
    {
        if ($this->disease !== $disease) {
            $this->disease = $disease;
        }

        return $this;
    }

    /**
     * Get the disease.
     *
     * @return Disease
     */
    public function getDisease()
    {
        return $this->disease;
    }
}
