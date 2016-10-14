<?php
namespace TestAppBundle\Controller;


class IndexController extends DefaultController
{
    public function indexAction()
    {
        return $this->render('cf/index.twig',[
            'articles'=>$this->findAllFromRepository('Article'),
        ]);
    }
}