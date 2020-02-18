<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;



class Blog extends AbstractController
{    
    /**
     * @Route("/", name="list")
     */
    public function listPosts()
    {
        $em = $this->getDoctrine()->getManager();
        
        $posts = $em->getRepository(Post::class)->findAll();
                
        return $this->render('posts/list.html.twig', [
            "posts" => $posts
        ]);
    }
    
    
    /**
     * @Route("/post/{id}/edit", name="edit", methods={"GET"})
     */
    public function editPost(int $id)
    {
        var_dump($id);
        return $this->render('posts/edit.html.twig');
    }
    
     /**
     * @Route("/post/add", name="add", methods={"GET"})
     */
    public function addPost()
    {
        return $this->render('posts/add.html.twig');
    }
    
     /**
     * @Route("/post/save", name="save", methods={"POST"})
     */
    public function savePost()
    {
        $title = $_POST['title'];
        $description = $_POST['description'];        
        
        $em = $this->getDoctrine()->getManager();
        
        $Post = new Post();
        
        $Post->setTitle($title);
        $Post->setDescription($description);
        
        $em->persist($Post);
        $em->flush();
        
        return $this->render('posts/success.html.twig');
    }
    
    /**
     * @Route("/post/{id}", name="show", methods={"GET"})
     */
    public function showPost(int $id)
    {
        var_dump($id);
        return $this->render('posts/show.html.twig');
    }
    
}
