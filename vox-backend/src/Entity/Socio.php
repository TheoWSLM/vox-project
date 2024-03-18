<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=SocioRepository::class)
 */
class Socio
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
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passWord;

    /**
     * @ORM\ManyToMany(targetEntity=Empresa::class)
     * @ORM\JoinTable(name="socio_empresa",
     *      joinColumns={@ORM\JoinColumn(name="socio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="empresa_id", referencedColumnName="id")}
     * )
     */
    private $empresas;

    public function __construct()
    {
        $this->empresas = new ArrayCollection();
    }


  /**
     * @return Collection|Empresa[]
     */
    public function getEmpresas(): Collection
    {
        return $this->empresas;
    }

    public function addEmpresa(Empresa $empresa): self
    {
        if (!$this->empresas->contains($empresa)) {
            $this->empresas[] = $empresa;
        }

        return $this;
    }

    public function removeEmpresa(Empresa $empresa): self
    {
        $this->empresas->removeElement($empresa);
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassWord(): ?string
    {
        return $this->passWord;
    }

    public function setPassword(string $passWord): self
    {
        $this->passWord = password_hash($passWord, PASSWORD_BCRYPT);
        return $this;
    }
}
