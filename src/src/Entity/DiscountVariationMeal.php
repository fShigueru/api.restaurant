<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountVariationMealRepository")
 */
class DiscountVariationMeal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="float")
     */
    private $ruleValue;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ruleInitDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ruleFinalDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getRuleValue(): ?float
    {
        return $this->ruleValue;
    }

    public function setRuleValue(float $ruleValue): self
    {
        $this->ruleValue = $ruleValue;

        return $this;
    }

    public function getRuleInitDate(): ?\DateTimeInterface
    {
        return $this->ruleInitDate;
    }

    public function setRuleInitDate(\DateTimeInterface $ruleInitDate): self
    {
        $this->ruleInitDate = $ruleInitDate;

        return $this;
    }

    public function getRuleFinalDate(): ?\DateTimeInterface
    {
        return $this->ruleFinalDate;
    }

    public function setRuleFinalDate(\DateTimeInterface $ruleFinalDate): self
    {
        $this->ruleFinalDate = $ruleFinalDate;

        return $this;
    }
}
