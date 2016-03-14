<?php

namespace Example;

use Doctrine\KeyValueStore\Mapping\Annotations as KeyValue;

/**
 * @KeyValue\Entity(storageName="people")
 */
class Person
{
    /**
     * @KeyValue\Id
     */
    private $name;

    private $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }
}