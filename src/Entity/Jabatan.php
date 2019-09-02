<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JabatanRepository")
 */
class Jabatan
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
    private $jabatan;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Karyawan", mappedBy="jabatan")
     */
    private $karyawans;

    public function __construct($jabatan)
    {
        $this->jabatan = $jabatan;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJabatan(): ?string
    {
        return $this->jabatan;
    }

    public function setJabatan(string $jabatan): self
    {
        $this->jabatan = $jabatan;

        return $this;
    }

    /**
     * @return Collection|Karyawan[]
     */
    public function getKaryawans(): Collection
    {
        return $this->karyawans;
    }

    public function addKaryawan(Karyawan $karyawan): self
    {
        if (!$this->karyawans->contains($karyawan)) {
            $this->karyawans[] = $karyawan;
            $karyawan->setJabatan($this);
        }

        return $this;
    }

    public function removeKaryawan(Karyawan $karyawan): self
    {
        if ($this->karyawans->contains($karyawan)) {
            $this->karyawans->removeElement($karyawan);
            // set the owning side to null (unless already changed)
            if ($karyawan->getJabatan() === $this) {
                $karyawan->setJabatan(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->jabatan;
    }
}
