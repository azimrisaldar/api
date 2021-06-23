<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class DefaultController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {

        $em = $this->getDoctrine()->getManager(); 

        $username = $request->get('username');
        $password = $request->get('password');
        $isActive = $request->get('isActive');

        $user = new User($username,$isActive);

        $user->setPassword($encoder->encodePassword($user, $password));

        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getUsername()));

    }

    /**
     * @Route ("api/get-user-details",name="get_user_details")
     */
    public function getUserDetails(): Response
    {
        dd($this->getUser());
    }
}
