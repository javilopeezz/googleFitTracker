<?php

namespace App\Entity;

use App\Repository\DatosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatosRepository::class)]
class Datos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $emailUsuario = null;

    #[ORM\Column]
    private ?int $pasos = null;

    #[ORM\Column]
    private ?float $distancia = null;

    #[ORM\Column]
    private ?float $peso = null;

    #[ORM\Column]
    private ?float $caloriasQuemadas = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailUsuario(): ?string
    {
        return $this->emailUsuario;
    }

    public function setEmailUsuario(string $emailUsuario): self
    {
        $this->emailUsuario = $emailUsuario;

        return $this;
    }

    public function getPasos(): ?int
    {
        return $this->pasos;
    }

    public function setPasos(int $pasos): self
    {
        $this->pasos = $pasos;

        return $this;
    }

    public function getDistancia(): ?float
    {
        return $this->distancia;
    }

    public function setDistancia(float $distancia): self
    {
        $this->distancia = $distancia;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getCaloriasQuemadas(): ?float
    {
        return $this->caloriasQuemadas;
    }

    public function setCaloriasQuemadas(float $caloriasQuemadas): self
    {
        $this->caloriasQuemadas = $caloriasQuemadas;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
