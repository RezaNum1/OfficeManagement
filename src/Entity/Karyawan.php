<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KaryawanRepository")
 */
class Karyawan
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
    private $nik;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nama;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alamat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jabatan", inversedBy="karyawans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jabatan;

//    public function __construct($nik, $nama, $email, $alamat, $jabatan)
//    {
//        $this->nik = $nik;
//        $this->nama = $nama;
//        $this->email = $email;
//        $this->alamat = $alamat;
//        $this->jabatan = $jabatan;
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNik(): ?string
    {
        return $this->nik;
    }

    public function setNik(string $nik): self
    {
        $this->nik = $nik;

        return $this;
    }

    public function getNama(): ?string
    {
        return $this->nama;
    }

    public function setNama(string $nama): self
    {
        $this->nama = $nama;

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

    public function getAlamat(): ?string
    {
        return $this->alamat;
    }

    public function setAlamat(string $alamat): self
    {
        $this->alamat = $alamat;

        return $this;
    }

    public function getJabatan(): ?Jabatan
    {
        return $this->jabatan;
    }

    public function setJabatan(?Jabatan $jabatan): self
    {
        $this->jabatan = $jabatan;

        return $this;
    }
}
