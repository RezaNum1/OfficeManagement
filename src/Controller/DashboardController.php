<?php

namespace App\Controller;

use App\Entity\Jabatan;
use App\Entity\Karyawan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Karyawan::class);
        $total = $repo->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $repos = $em->getRepository(Jabatan::class);
        $totalJabatan = $repos->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

       return $this->render('/dashboard/dashboard.html.twig', array('total' => $total, 'total_jabatan' => $totalJabatan));
    }
}
