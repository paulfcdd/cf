<?php

namespace TestAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function em(){
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $name
     * @return array
     */
    public function findAllFromRepository($name){
        return $this->em()->getRepository("TestAppBundle:$name")->findAll();
    }

    /**
     * @param $name
     * @param array $params
     * @return object
     */
    public function findOneFromRepository($name, array $params){
        return $this->em()->getRepository("TestAppBundle:$name")->findOneBy($params);
    }

    /**
     * @param $name
     * @param array $params
     * @return object
     */
    public function findByFromRepository($name, array $params){
        return $this->em()->getRepository("TestAppBundle:$name")->findBy($params);
    }
}
