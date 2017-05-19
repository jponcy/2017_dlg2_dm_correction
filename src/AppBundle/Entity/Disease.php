<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Disease.
 *
 * @ORM\Table(name="disease")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiseaseRepository")
 */
class Disease
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="treatment", type="text", nullable=true)
     *
     * @var string
     */
    private $treatment;

    /**
     * @ORM\ManyToMany(targetEntity="Species", inversedBy="diseases")
     * @ORM\JoinTable(name="diseases_specie",
     * joinColumns={@ORM\JoinColumn(name="disease_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="species_id", referencedColumnName="id")}
     * )
     *
     * @var Collection
     */
    private $species;

    /**
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="disease")
     *
     * @var Collection
     */
    protected $appointments;

    /**
     * Default Construct.
     */
    public function __construct()
    {
        $this->species = new ArrayCollection();
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
     * @return Disease
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
     * Set treatment
     *
     * @param string $treatment
     * @return Disease
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return string
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * Add a specie.
     *
     * @param Species $specie
     *
     * @return Disease
     */
    public function addSpecies(Species $specie)
    {
        if ($specie && $this->species->contains($specie) === false) {
            $this->species->add($specie);
            $specie->addDisease($this);
        }

        return $this;
    }

    /**
     * Remove given specie.
     *
     * @param Species $specie
     *
     * @return Disease
     */
    public function removeSpecies(Species $specie)
    {
        if ($specie && $this->species->contains($specie)) {
            $this->species->removeElement($specie);
        }

        return $this;
    }

    /**
     * Set the specie collection.
     *
     * @param Collection $species
     *
     * @return Disease
     */
    public function setSpecie(Collection $species)
    {
        if ($species) {
            $this->species = $species;

            foreach ($species as $specie) {
                $specie->addDisease($this);
            }
        }

        return $this;
    }

    /**
     * Get the species.
     *
     * @return Collection
     */
    public function getSpecie()
    {
        return $this->species;
    }

    /**
     * Add a appointment.
     *
     * @param Appointment $appointment
     *
     * @return Disease
     */
    public function addAppointment(Appointment $appointment)
    {
        if ($appointment && $this->appointments->contains($appointment) === false) {
            $this->appointments->add($appointment);
            $appointment->setDisease($this);
        }

        return $this;
    }

    /**
     * Remove given appointment.
     *
     * @param Appointment $appointment
     *
     * @return Disease
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
     * @return Collection|Appointment[]
     */
    public function getAppointments()
    {
        return $this->appointments;
    }
}
