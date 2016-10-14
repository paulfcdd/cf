<?php

namespace TestAppBundle\Service;

use Doctrine\ORM\EntityManager;
use Michelf\Markdown;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use TestAppBundle\Entity\Comment;

class AddComment
{
   
   public $em;
   public $logger;
   public $router;

   public function __construct(EntityManager $entityManager, Logger $logger, RouterInterface $router)
   {
      $this->em = $entityManager;
      $this->logger = $logger;
      $this->router = $router;
   }

   public function writeData($data){
      $markdown = new Markdown();
      
      $form = $data['form'];
      $articleId = $data['articleId'];
      $name = $form['name'];
      $content = $form['content'];
      $date = date('d-m-Y G:i');


      $markdown->transform($content);

      $comment = new Comment();
      $comment->setArticleId($articleId);
      $comment->setName($name);
      $comment->setDate($date);
      $comment->setContent($markdown->transform($content));
      $this->em->persist($comment);
      try {
         $this->em->flush();
         $this->logger->addInfo('Comment was added');
         return true;
      } catch (\Exception $e) {
         $this->logger->addError($e->getMessage());
         return false;
      }
   }
   
   public function deleteComment($id){
      $comment = $this->em->getRepository('TestAppBundle:Comment')->find($id);
      $this->em->remove($comment);
      try{
         $this->em->flush();
         $this->logger->addInfo('Comment was removed');
         return true;
      } catch(\Exception $e){
         $this->logger->addError($e->getMessage());
         return false;
      }
   }
   
   public function editComment($id, $content){
      $markdown = new Markdown();
      $comment = $this->em->getRepository('TestAppBundle:Comment')->find($id);
      $comment->setContent($markdown->transform($content));
      try{
         $this->em->flush();
         $this->logger->addInfo('Comment was edited');
         return true;
      } catch(\Exception $e){
         $this->logger->addError($e->getMessage());
         return false;
      }
   }
}