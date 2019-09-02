<?php

namespace App\Controller;

use App\Entity\Jabatan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class JabatanController extends Controller
{
    /**
     * @Route("/jabatan", name="jabatan")
     */
    public function index(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Jabatan::class)->findAll();
        $paginator = $this->get('knp_paginator');
        $datas = $paginator->paginate(
            $data, $request->query->getInt('page', 1), 5 );
        return $this->render('jabatan/index.html.twig',['datas' => $datas]);
    }

    /**
     * @Route("/jabatan/create", name="jabatan_create")
     * @Method({"POST"})
     */
    public function create(Request $request){

        $jabatan = $request->get('jabatan');
        $data = new Jabatan($jabatan);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        $this->addFlash('success', 'Berhasil Menambahkan Data!');
        return $this->redirectToRoute('jabatan');
    }
}
