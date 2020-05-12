<?php

namespace App\Controller;

use App\Entity\BudgetCard;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class BudgetCardController extends AbstractController
{

    /**
     * @Route("/api/budget-card-by-userId/{userId}", name="api_get-list_budget_card", methods={"GET"})
     */
    public function get_budgetCard_by_user(int $userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId]);
        return $this->json($user, 200, [], ['groups' => 'budget-card-get-list']);
    }

    /**
     * @Route("/api/budget-card/create", name="api_budget_card_create", methods={"POST"})
     */
    public function createBudgetCard(Request $request, EntityManagerInterface $emi)
    {
        $req = json_decode($request->getContent(), true);

        $title = $req['title'];
        $ceil = $req['ceil'];
        $limitDate = $req['limitDate'];
        $currentMoney = $req['currentMoney'];
        $userId = $req['userId'];

        try {
            $budgetCardToCreate = new BudgetCard();

            $user = $this->getDoctrine()->getRepository(User::class)->findBy(["id" => $userId]);

            $budgetCardToCreate->setTitle($title);
            $budgetCardToCreate->setCeil($ceil);
            $budgetCardToCreate->setLimitDate(new DateTime($limitDate));
            $budgetCardToCreate->setCurrentMoney($currentMoney);
            $budgetCardToCreate->setUser($user[0]);
            $budgetCardToCreate->setCreatedAt(new DateTime());

            $emi->persist($budgetCardToCreate);
            $emi->flush();

            return $this->json($budgetCardToCreate, 201, [], ["groups" => "budget-card-create"]);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
