<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleUserService
{
    private EntityManagerInterface $entityManager;
    private SocialsUserService $socialsUserService;
    private CloudService $cloudService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param SocialsUserService $socialsUserService
     * @param CloudService $cloudService
     */
    public function __construct(EntityManagerInterface $entityManager, SocialsUserService $socialsUserService, CloudService $cloudService)
    {
        $this->entityManager = $entityManager;
        $this->socialsUserService = $socialsUserService;
        $this->cloudService = $cloudService;
    }


    public function getPassport(OAuth2ClientInterface $client, AccessToken $accessToken){
        return new SelfValidatingPassport(
            new UserBadge(
                $accessToken->getToken(),
                function() use($client, $accessToken){
                    /**
                     * @var GoogleUser $googleUser
                     */
                    $googleUser = $client->fetchUserFromToken($accessToken);
                    $existingUser = $this->entityManager
                        ->getRepository(User::class)
                        ->findOneBy(['google_id' => $googleUser->getId()]);
                    if($existingUser){
                        return $existingUser;
                    }
                    $user = $this->entityManager
                        ->getRepository(User::class)
                        ->findOneBy(['email' => $googleUser->getEmail()]);
                    if($user){
                        $user->setGoogleId($googleUser->getId());
                    } else {
                        $user = $this->socialsUserService->getGoogleUser($googleUser);
                    }
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    $this->cloudService->setDefaultAvatar($user->getId());
                    return $user;
                }
            )
        );
    }
}