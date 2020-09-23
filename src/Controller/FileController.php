<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FileController extends AbstractController{
    /**
     * @Route("/file", name="file")
     */
    public function import(Request $request)
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo(
                    $photo->getClientOriginalName(), PATHINFO_FILENAME
                );
                $newFilename = uniqid('photo_user_').'.'.$photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('photos_users_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // erreur d'upload (généralement problème de droits 
                    // sur le répertoire de destination)
                }
                // ici on voit la relation en ManyToOne
                $file->setPhoto($newFilename);
            }
     
          //  return $this->redirectToRoute('profil');
        } 
    
        return $this->render('ticket/file.html.twig', [
            'form' => $form->createView(),
        ]);
    }   

    
}