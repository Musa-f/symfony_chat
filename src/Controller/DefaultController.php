<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Connection;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    private $security;
    private $entity;

    public function __construct(Security $security, EntityManagerInterface $entity)
    {
        $this->security = $security;
        $this->entity = $entity;
    }

    #[Route('/', name: 'app_default')]
    public function index(Security $security): Response
    {

        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->security->getUser();
            $connections = $this->entity->getRepository(Connection::class)->findAllConnections($user->getId());
            $messages = $this->entity->getRepository(Message::class)->findAllMesssages($user->getId());

            return $this->render('homepage.html.twig', [
                "connections" => $connections,
                "messages" => $messages
            ]);
        }

        return $this->redirectToRoute('app_login');

    }
}
