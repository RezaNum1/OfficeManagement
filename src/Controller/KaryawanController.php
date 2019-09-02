<?php

namespace App\Controller;

use App\Entity\Jabatan;
use App\Entity\Karyawan;
use App\Repository\KaryawanRepository;
use App\Service\MessageGenerator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Service\KaryawanService;

class KaryawanController extends Controller
{
    /**
     * @Route("/karyawan", name="data_karyawan")
     */
    public function index(Request $request)
    {
        $data =$this->getDoctrine()->getRepository(Karyawan::class)->findAll();
        $paginator = $this->get('knp_paginator');
        $datas = $paginator->paginate(
            $data, $request->query->getInt('page', 1), 5);
        return $this->render('/karyawan/index.html.twig', array('datas' => $datas));
    }

    /**
     * @Route("/karyawan/create", name="karyawan_create")
     * @Method({"POST"})
     */
    public function create(Request $request, KaryawanService $karyawan){

        $data = new Karyawan();

        // Get Last ID
//        $em = $this->getDoctrine()->getManager();
//        $repository = $em->getRepository(Karyawan::class);
//        $results = $repository->setMaxResults(1)->orderBy('id', 'DESC');
//        $last = $results->getQuery()->getSingleResult();
//        dd($last);

//        $data = $this->getDoctrine()->getManager();
//        $repo = $data->getRepository(Karyawan::class);
//        $get = $repo->findBy(array(),['nik' => 'desc']);
//        $last = $get[0]->getNik();

//        // Get Last Nik
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u FROM App\Entity\Karyawan u ORDER BY u.nik DESC');
        $result = $query->getResult();
        if($result == []){
            $final = '48160001';
        }else{
            $final = $result[0]->getNik() + 1.;
        }

        // Process
        $form = $this->createFormBuilder($data)
            ->add('nik', NumberType::class, ['attr' => ['class' => 'form-control'], 'data' => $final])
            ->add('nama', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control']])
            ->add('alamat', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('jabatan', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'class' => Jabatan::class,
                'choice_label' => 'jabatan'
            ])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-3 btn-block']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();

            $this->addFlash('success', 'Berhasil Menambahkan Data');
            return $this->redirectToRoute('data_karyawan');
        }

        return $this->render('/karyawan/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/karyawan/show/{id}")
     * @Method({"GET"}, {"POST"})
     */
    public function show($id){
        $datas = $this->getDoctrine()->getRepository(Karyawan::class)->findOneBy(['id' => $id]);
        return $this->render('/karyawan/show.html.twig', ['datas' => $datas]);

    }

    /**
     * @Route("/karyawan/edit/{id}")
     * @Method({"POST", "GET"})
     */
    public function edit(Request $request, $id, MessageGenerator $messageGenerator){

        $datas = $this->getDoctrine()->getRepository(Karyawan::class)->find($id);

        $form = $this->createFormBuilder($datas)->
        add('nik', NumberType::class, array('attr' => array('class' => 'form-control')))->
        add('nama', TextType::class, array('attr' => array('class' => 'form-control')))->
        add('email', EmailType::class, array('attr' => array('class' => 'form-control')))->
        add('alamat', TextareaType::class, array('attr' => array('class' => 'form-control')))->
        add('jabatan', EntityType::class, [
            'attr' => ['class' => 'form-control'],
            'class' => Jabatan::class,
            'choice_label' => 'jabatan'
        ])->
        add('edit', SubmitType::class, array('label' => 'Edit', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $message = $messageGenerator->getHappyMassage();
            $this->addFlash('success', $message);
//            $this->addFlash('success', 'Berhasil Mengubah Data');
            return $this->redirectToRoute('data_karyawan');
        }
        return $this->render('/karyawan/edit.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/karyawan/delete/{id}")
     * @Method("DELETE")
     */
    public function delete($id){
        $datakar = $this->getDoctrine()->getRepository(Karyawan::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($datakar);
        $em->flush();
        $response = new Response();
        $response->send();

        $this->addFlash('success', 'Berhasil Menghapus Data');
        return $this->redirectToRoute('data_karyawan');
    }

    /**
     * @Route("/karyawan/search")
     * @Method({"GET"})
     */
    public function search(Request $request){
        $getData = $request->get('search');
        if($getData){
            $repo = $this->getDoctrine()->getRepository(Karyawan::class);
            if($repo->findBy(['nama' => $getData]) != []){
                $data = $repo->findBy(['nama' => $getData]);
                $paginator = $this->get('knp_paginator');
                $datas = $paginator->paginate(
                    $data, $request->query->getInt('page', 1), 5);
                return $this->render('/karyawan/index.html.twig', array('datas' => $datas));
            }else{
                if($repo->findBy(['nik' => $getData])!= []){
                    $data = $repo->findBy(['nik' => $getData]);
                    $paginator = $this->get('knp_paginator');
                    $datas = $paginator->paginate(
                        $data, $request->query->getInt('page', 1), 5);
                    return $this->render('/karyawan/index.html.twig', array('datas' => $datas));
                }else{
                    $this->addFlash('error', 'Data Not Found');
                    return $this->redirectToRoute('data_karyawan');
                }
            }
        }


    }
}
