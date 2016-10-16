<?php

namespace Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Michelf\Markdown;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Routing\RouterInterface;
use TestAppBundle\Entity\Comment;
use TestAppBundle\Service\AddComment;

class AddCommentTest extends \PHPUnit_Framework_TestCase
{
    
    public function testInit(){
        $data = [
            'form' => [
                'name' => 'Paul',
                'content' => 'Test',
            ],
            'articleId' => '1'
        ];
        
        $id = '9';
        
        $content = 'test';


        $commentRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($commentRepository));
        
        $logger = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $router = $this->getMockBuilder(RouterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $markdown = $this->getMockBuilder(Markdown::class)
            ->disableOriginalConstructor()
            ->getMock();

        $addComment = new AddComment($em, $logger, $router, $markdown);
        $this->assertEquals(true, $addComment->writeData($data));
        $this->assertEquals(true, $addComment->deleteComment($id));
//        $this->assertEquals(true, $addComment->editComment($id, $content));
    }
}