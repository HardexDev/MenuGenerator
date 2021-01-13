<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Week;
use App\Entity\Aliment;
use App\Form\GenerationParametersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenerationController extends AbstractController
{
    /**
     * @Route("/generate", name="generation")
     */
    public function index(Request $request, Security $security): Response
    {
        $numToCat = array(
            '1' => "viande",
            '2' => "poisson",
            '3' => "oeuf",
            '4' => "légume",
            '5' => "yaourt",
            '6' => "fromage",
            '7' => "fruit",
            '8' => "gourmand",
            '9' => "autre"
        );

        $this->denyAccessUnlessGranted('ROLE_USER');
        $connectedUser = $security->getUser();

        $weeks = $connectedUser->getIdweek();

        $hasWeeksGenerated = !$weeks->isEmpty();

        $parameters_form = $this->createForm(GenerationParametersType::class);

        $parameters_form->handleRequest($request);

        if ($hasWeeksGenerated){
            
            $week = $weeks[\sizeof($weeks) - 1];
            $week_aliments_dishes = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDishesDistinct($week);
            $week_aliments_desserts = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDessertsDistinct($week);

            if ($parameters_form->isSubmitted()){
                
                $data = $parameters_form->getData();
                $week = $this->getDoctrine()->getRepository(Week::class)->findOneByRandom($data, $security);
                $week->addIdclient($connectedUser);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($week);
                $entityManager->flush();
    
                $week_aliments_dishes = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDishesDistinct($week);
                $week_aliments_desserts = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDessertsDistinct($week);
            }
            
            return $this->render('generation/index.html.twig', [
                'controller_name' => 'GenerationController',
                'week' => $week,
                'week_aliments_dishes' => $week_aliments_dishes,
                'week_aliments_desserts' => $week_aliments_desserts,
                'parameters_form' => $parameters_form->createView(),
                'hasWeeksGenerated' => $hasWeeksGenerated,
                'categories' => $numToCat,
            ]);
        }

        if ($parameters_form->isSubmitted()){
            $data = $parameters_form->getData();
            $week = $this->getDoctrine()->getRepository(Week::class)->findOneByRandom($data, $security);
            $week->addIdclient($connectedUser);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($week);
            $entityManager->flush();

            $hasWeeksGenerated = true;

            $week_aliments_dishes = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDishesDistinct($week);
            $week_aliments_desserts = $this->getDoctrine()->getRepository(Aliment::class)->findAllByWeekDessertsDistinct($week);

            return $this->render('generation/index.html.twig', [
                'controller_name' => 'GenerationController',
                'week' => $week,
                'week_aliments_dishes' => $week_aliments_dishes,
                'week_aliments_desserts' => $week_aliments_desserts,
                'parameters_form' => $parameters_form->createView(),
                'hasWeeksGenerated' => $hasWeeksGenerated,
                'categories' => $numToCat,
            ]);
            
            
        }

        return $this->render('generation/index.html.twig', [
            'controller_name' => 'GenerationController',
            'parameters_form' => $parameters_form->createView(),
            'hasWeeksGenerated' => $hasWeeksGenerated,
        ]);
    }

    /**
     * @Route("/generate/test", name="generation_test")
     */
    public function testData(Request $request): Response
    {
        return $this->render('generation/test.html.twig', [
            'controller_name' => 'GenerationController',
        ]);
    }


}
