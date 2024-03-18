<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=SocioRepository::class)
 */
class Empresa
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomeFantasia;

       /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomeFormal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cnpj;
    




    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNomeFantasia(): ?string
    {
        return $this->nomeFantasia;
    }

    public function setNomeFantasia(string $nomeFantasia): self
    {
        $this->nomeFantasia = $nomeFantasia;
        return $this;
    }
    public function getNomeFormal(): ?string
    {
        return $this->nomeFormal;
    }

    public function setNomeFormal(string $nomeFormal): self
    {
        $this->nomeFormal = $nomeFormal;
        return $this;
    }
    
    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;
        return $this;
    }

}
