<?php

namespace TestAppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use TestAppBundle\Entity\Comment;

class ArticleController extends DefaultController
{

    public function addCommentForm(){
        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('name', TextType::class)
            ->add('content', TextareaType::class)
            ->add('Add comment', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success',
                    'type' => 'submit',
                ],
            ])
            ->getForm();

        return $form->createView();
    }

    public function getCommentAction(){
        $id = $_POST['articleId'];
        if ($this->get('add_comment')->writeData($_POST) ==  true){
           return $this->redirectToRoute('article', ['id' => $id]);
        }
    }

    public function deleteCommentAction(Request $request){
        $id = $request->request->get('id');
        if ($this->get('add_comment')->deleteComment($id) == true) {
            return new Response('success');
        } else {
            return new Response('Error while remove comment');
        }
    }
    
    public function editCommentAction(Request $request){
        $id = $request->request->get('id');
        $content = $request->request->get('content');
        if ($this->get('add_comment')->editComment($id, $content) == true) {
            return new Response('success');
        } else {
            return new Response('Error while edit comment');
        }
    }
    
    public function indexAction($id){
        $comments = $this->findByFromRepository('Comment', ['articleId'=>$id]);
        $countComments = count($comments);
        $markdown = $this->get('add_comment');
        return $this->render('cf/article.twig',[
            'article' => $this->findOneFromRepository('Article', ['id'=>$id]),
            'commentNumber' => $countComments,
            'form' => $this->addCommentForm(),
            'comments' => $comments,
        ]);
    }
}