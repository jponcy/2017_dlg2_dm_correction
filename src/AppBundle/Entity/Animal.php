<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Animal
 *
 * @ORM\Table(name="animal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimalRepository")
 */
class Animal
{

    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="animal")
     *
     * @var Collection
     */
    private $appointments;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Animal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add a appointment.
     *
     * @param AppBundle\Entity\Appointment $appointment
     *
     * @return Animal
     */
    public function addAppointment(Appointment $appointment)
    {
        if ($appointment && $this->appointments->contains($appointment) === false) {
            $this->appointments->add($appointment);
            $appointment->setAnimal($this);
        }

        return $this;
    }

    /**
     * Remove given appointment.
     *
     * @param AppBundle\Entity\Appointment $appointment
     *
     * @return Animal
     */
    public function removeAppointment(Appointment $appointment)
    {
        if ($appointment && $this->appointments->contains($appointment)) {
            $this->appointments->removeElement($appointment);
        }

        return $this;
    }

    /**
     * Get the appointments.
     *
     * @return Collection|AppBundle\Entity\Appointment[]
     */
    public function getAppointments()
    {
        return $this->appointments;
    }
}
