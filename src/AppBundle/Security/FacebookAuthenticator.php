<?php
namespace AppBundle\Security;

use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use AppBundle\Entity\User;

class FacebookAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManager $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        //echo "<li>Get credentials";

        if ($request->getPathInfo() == '/' && $request->query->get('code') != null)
        {
            return $this->fetchAccessToken($this->getFacebookClient());
        }
        else
        {
            return;
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //echo "<li>GetUser";
        /** @var FacebookUser $facebookUser */

        $facebookUser = $this->getFacebookClient()
            ->fetchUserFromToken($credentials);

        $email = $facebookUser->getEmail();

        // check if registered before
        $existingUser = $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $facebookUser->getEmail()]);
        if ($existingUser) {
            return $existingUser;
        }

        // register new user
        $user = new User();
        $user
            ->setFacebookId($facebookUser->getId())
            ->setRoles('ROLE_USER')
            ->setName($facebookUser->getName())
            ->setAvatara(file_get_contents($facebookUser->getPictureUrl()))
            ->setEmail($facebookUser->getEmail())
            ->setApiKey($credentials);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @return FacebookClient
     */
    private function getFacebookClient()
    {
        return $this->clientRegistry
            ->getClient('facebook_main');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        //echo "<li>onAuthenticationSuccess";
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        die('Auth failed');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        die('Auth required');
    }

}

?>
