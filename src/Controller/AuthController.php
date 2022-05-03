<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
    #[Route('/auth/register', name: 'register',methods:"POST")]
    public function register(Request $request, UserPasswordHasherInterface $encoder,ManagerRegistry $doctrine):Response
    {
        $password = $request->get('password');
        $email = $request->get('email');
        $user = new User();
        $user->setPassword($encoder->hashPassword($user,$password));
        $user->setEmail($email);
         $user->setRoles(['ROLE_USER']);
        $em = $doctrine->getManager();
        //$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->json([
            'user' => $user->getEmail()
        ]);
    }

    #[Route('/auth/login', name: 'login',methods:"POST")]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder):Response
   {
        $user = $userRepository->findOneBy([
                'email'=>$request->get('email'),
        ]);
        if (!$user || !$encoder->isPasswordValid($user, $request->get('password'))) {
                return $this->json([
                    'message' => 'email or password is wrong.',
                ]);
        }
       $payload = [
           "user" => $user->getEmail(),
           "exp"  => (new \DateTime())->modify("+5 minutes")->getTimestamp(),
       ];


        $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS256');
        return $this->json([
            'message' => 'success!',
            'token' => sprintf('Bearer %s', $jwt),
        ]);
    }
}
