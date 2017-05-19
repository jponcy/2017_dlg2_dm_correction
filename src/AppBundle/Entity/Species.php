<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Species
 *
 * @ORM\Table(name="species")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpeciesRepository")
 */
class Species
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
     * @ORM\OneToMany(targetEntity="Animal", mappedBy="species")
     *
     * @var Collection
     */
    protected $animals;

    /**
     * @ORM\ManyToMany(targetEntity="Disease", mappedBy="species")
     *
     * @var ArrayCollection
     */
    private $diseases;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->diseases = new ArrayCollection();
    }

    /**
     * ToString.
     */
    public function __toString()
    {
        return $this->getName();
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
     * @return Species
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
     * Add a animal.
     *
     * @param Animal $animal
     *
     * @return Species
     */
    public function addAnimal(Animal $animal)
    {
        if ($animal && $this->animals->contains($animal) === false) {
            $this->animals->add($animal);
            $animal->setSpecies($this);
        }

        return $this;
    }

    /**
     * Remove given animal.
     *
     * @param Animal $animal
     *
     * @return Species
     */
    public function removeAnimal(Animal $animal)
    {
        if ($animal && $this->animals->contains($animal)) {
            $this->animals->removeElement($animal);
        }

        return $this;
    }

    /**
     * Get the animals.
     *
     * @return Collection|Animal[]
     */
    public function getAnimals()
    {
        return $this->animals;
    }

    /**
     * Add a disease.
     *
     * @param Disease $disease
     *
     * @return Species
     */
    public function addDisease(Disease $disease)
    {
        if ($disease && $this->diseases->contains($disease) === false) {
            $this->diseases->add($disease);
            $disease->addSpecies($this);
        }

        return $this;
    }

    /**
     * Remove given disease.
     *
     * @param Disease $disease
     *
     * @return Species
     */
    public function removeDisease(Disease $disease)
    {
        if ($disease && $this->diseases->contains($disease)) {
            $this->diseases->removeElement($disease);
        }

        return $this;
    }

    /**
     * Set the disease collection.
     *
     * @param Collection $diseases
     *
     * @return Species
     */
    public function setDiseases(Collection $diseases)
    {
        if ($diseases) {
            $this->diseases = $diseases;

            foreach ($diseases as $disease) {
                $disease->addSpecies($this);
            }
        }

        return $this;
    }

    /**
     * Get the diseases.
     *
     * @return Disease
     */
    public function getDiseases()
    {
        return $this->diseases;
    }
}
