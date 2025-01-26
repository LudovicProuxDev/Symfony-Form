<?php

namespace App\Controller;

use App\Entity\Formtest;
use App\Form\FormtestType;
use App\Repository\FormtestRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class FormtestController extends AbstractController
{
    #[Route('/', name: 'app_formtest_index', methods: ['GET'])]
    public function index(FormtestRepository $formtestRepository): Response
    {
        return $this->render('formtest/index.html.twig', [
            'formtests' => $formtestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formtest_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $formtest = new Formtest();
        $form = $this->createForm(FormtestType::class, $formtest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload($image);
                $formtest->setImage($imageFileName);
            }
            /** @var UploadedFile $pdf */
            $pdf = $form->get('pdf')->getData();
            if ($pdf) {
                $pdfFileName = $fileUploader->upload($pdf);
                $formtest->setPdf($pdfFileName);
            }
            $entityManager->persist($formtest);
            $entityManager->flush();

            return $this->redirectToRoute('app_formtest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formtest/new.html.twig', [
            'formtest' => $formtest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formtest_show', methods: ['GET'])]
    public function show(Formtest $formtest): Response
    {
        return $this->render('formtest/show.html.twig', [
            'formtest' => $formtest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formtest_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formtest $formtest, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(FormtestType::class, $formtest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Service to remove the files
            $filesystem = new Filesystem();

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image) {
                // Rename the file if exists
                if ($filesystem->exists($fileUploader->getImagesDirectory() . '/' . $formtest->getImage())) {
                    $filesystem->remove($fileUploader->getImagesDirectory() . '/' . $formtest->getImage());
                }
                $imageFileName = $fileUploader->upload($image);
                $formtest->setImage($imageFileName);
            }
            /** @var UploadedFile $pdf */
            $pdf = $form->get('pdf')->getData();
            if ($pdf) {
                // Rename the file if exists
                if ($filesystem->exists($fileUploader->getPdfDirectory() . '/' . $formtest->getPdf())) {
                    $filesystem->remove($fileUploader->getPdfDirectory() . '/' . $formtest->getPdf());
                }
                $pdfFileName = $fileUploader->upload($pdf);
                $formtest->setPdf($pdfFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_formtest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formtest/edit.html.twig', [
            'formtest' => $formtest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formtest_delete', methods: ['POST'])]
    public function delete(Request $request, Formtest $formtest, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete' . $formtest->getId(), $request->getPayload()->getString('_token'))) {
            // Service to remove the files
            $filesystem = new Filesystem();
            $filesystem->remove($fileUploader->getImagesDirectory() . '/' . $formtest->getImage());
            $filesystem->remove($fileUploader->getPdfDirectory() . '/' . $formtest->getPdf());

            $entityManager->remove($formtest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formtest_index', [], Response::HTTP_SEE_OTHER);
    }
}
