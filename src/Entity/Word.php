<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 18:29
 */

namespace App\Entity;


class Word
{

    /**
     * Holds the name of the Word
     * @var string $name
     */
    private $name;

    /**
     * Holds the number of time this Word appears in the repository
     * @var int $frequency
     */
    private $frequency;

    /**
     * Word constructor. Setting the initial name and frequency of the Word
     * @param string $name
     * @param int $frequency
     */
    public function __construct(string $name, int $frequency)
    {
        $this->name = $name;
        $this->frequency = $frequency;
    }

    /**
     * Returns the name of the Word
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the frequency of the Word
     * @return int
     */
    public function getFrequency(): int
    {
        return $this->frequency;
    }
}