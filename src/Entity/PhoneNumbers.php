<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneNumbersRepository")
 */
class PhoneNumbers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\People", inversedBy="phone_numbers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $people;


    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"default"})
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="people_id")
     * @Groups({"default"})
     */
    private $people_id;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     * @Groups({"default"})
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @Groups({"default"})
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return int
     * @Groups({"default"})
     */
    public function getPeopleId()
    {
        return $this->people_id;
    }

    /**
     * @param int $people_id
     * @Groups({"default"})
     */
    public function setPeopleId(int $people_id)
    {
        $this->people_id = $people_id;
    }

    public function getPeople(): People
    {
        return $this->people;
    }

    public function setPeople(People $people)
    {
        $this->people = $people;
    }


}
