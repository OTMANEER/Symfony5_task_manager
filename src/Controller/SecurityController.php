<?php
/**
 * @author Aymane EL IDRISSI 
 */
namespace App\Controller;
// namespace App\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{
    private UrlGeneratorInterface $urlGenerator;
    public const LOGIN_ROUTE = 'app_login';


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): ?Response
    {


        
        $user = $this->getUser();

        // if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
        //     return new RedirectResponse($targetPath);
        // }
        // $user = $token->getUser();

        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('admin'));
        } 
        if (in_array("ROLE_PROJECT_CHEF", $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('Project_Manager2'));

        }
        if (in_array("ROLE_MEMBER", $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('Project'));
        }
        if (in_array("ROLE_EQUIPE_CHEF", $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('Project'));
        }
        // For example:
        return new RedirectResponse($this->urlGenerator->generate('hello_world'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        // return $this->redirectToRoute('app_login');
    }
    

}
