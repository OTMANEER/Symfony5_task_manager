<?php
/**
* @author Sami DAHMANI
*/
  namespace App\EventSubscriber;

  use App\Entity\User;
  use Doctrine\ORM\EntityManagerInterface;
  use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
  use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
  use Symfony\Component\EventDispatcher\EventSubscriberInterface;
  use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
  use Symfony\Component\Security\Core\User\UserInterface;

  class EasyAdminSubscriber implements EventSubscriberInterface
  {

      private $entityManager;
      private $passwordEncoder;

      public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
      {
          $this->entityManager = $entityManager;
          $this->passwordEncoder = $passwordEncoder;
      }

      public static function getSubscribedEvents()
      {
          return [
              BeforeEntityPersistedEvent::class => ['addUser'],
              BeforeEntityUpdatedEvent::class => ['updateUser'], //surtout utile lors d'un reset de mot passe plutôt qu'un réel update, car l'update va de nouveau encrypter le mot de passe DEJA encrypté ...
          ];
      }

      public function updateUser(BeforeEntityUpdatedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) {
              return;
          }
          $this->setPasswordUpdate($entity);
      }

      public function addUser(BeforeEntityPersistedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) {
              return;
          }
          $this->setPassword($entity);
      }

      /**
       * @param User $entity
       */
      public function setPassword(User $entity): void
      {
          $pass = $entity->getEncpassword();

          $entity->setEncpassword(
              $this->passwordEncoder->encodePassword(
                  $entity,
                  $pass
              )
          );
          $this->entityManager->persist($entity);
          $this->entityManager->flush();
      }
      public function setPasswordUpdate(User $entity): void

      {
        $pass = $entity->getpassword2();
        if ($pass == NULL){
            return;
        }
        else {
            $entity->setEncpassword($pass);
            $entity->setEncpassword(
                $this->passwordEncoder->encodePassword(
                    $entity,
                    $pass
                )
            );
            $entity->setpassword2(null);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
      }

  }