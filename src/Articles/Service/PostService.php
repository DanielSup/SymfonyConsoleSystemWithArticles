<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:08
 */

namespace Articles\Service;


use Articles\Model\Model\Article;
use Articles\Model\Model\Post;
use Articles\Model\Model\User;

class PostService
{
    use SingletonTrait;
    public function getPosts(){
        return Post::walk();
    }
    public function getPostOfTheAuthoToTheArticle(User $author, Article $article){
        $posts = Post::walk();
        $postArray = array();
        foreach ($posts as $post){
            if($post->getAuthor() == $author && $post->getArticle() == $article){
                $postArray[$post->getId()] = $post;
            }
        }
        return $postArray;
    }
    public function addPost(User $author, Article $article, $text){
        $post = new Post($author, $article, $text);
        $author->addPost($post);
        $article->addPost($post);
        $post->save();
        $author->save();
        $article->save();
        return $post;
    }
    public function removePost(Post $post){
        $post->getAuthor()->removePost($post);
        $post->getArticle()->removePost($post);
        $post->getAuthor()->save();
        $post->getArticle()->save();
    }
}