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
     * @Route("/post/edit/{id}", name="edit", methods={"GET"})
     */
    public function editPost(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $Post = $em->find(Post::class, $id);
        
        return $this->render('posts/edit.html.twig', ['post'=> $Post]);
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
        
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            
            $Post = $em->find(Post::class, $id);
            
            $Post->setTitle($title);
            $Post->setDescription($description);
            
            return $this->render('posts/success_updated.html.twig');
        }
        
       
        
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
        $em = $this->getDoctrine()->getManager();
        
        $Post = $em->find(Post::class, $id); 
        
        return $this->render('posts/show.html.twig', ['post'=> $Post]);
    }
    
    
    /**
     * @Route("/post/remove/{id}", name="remove", methods={"GET"})
     */
    public function removePost(int $id)
    {        
        $em = $this->getDoctrine()->getManager();
        
        $Post = $em->find(Post::class, $id);        
        
        $em->remove($Post);
        
        $em->flush();
        
        return $this->render('posts/success_remove.html.twig');
    }
    
}
