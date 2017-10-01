<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:10
 */

namespace Articles\Service;


use Articles\Model\Model\User;
use Articles\Model\Model\Article;
use Articles\Model\Model\Model;
use Articles\Model\Model\System;
use Articles\Model\Model\Topic;

class ArticleService
{
    use SingletonTrait;
    public function getArticles(){
        return Article::walk();
    }
    public function findArticle($id){
        try {
            $article = Article::find($id);
            return $article;
        } catch(\Exception $ex){
            return null;
        }
    }
    public function addArticle(Topic $topic, User $author, $title, $description){
        $article = new Article($topic, $author, $title, $description);
        $topic->addArticle($article);
        $author->addArticle($article);
        $article->save();
        $topic->save();
        $author->save();
        return $article;
    }
    public function removeArticle(Article $article){
        $article->getAuthor()->removeArticle($article);
        $article->getTopic()->removeArticle($article);
        $article->getAuthor()->save();
        $article->getTopic()->save();
        $posts = $article->getPosts();
        $reviews = $article->getReviews();
        foreach ($posts as $post){
            $post->getAuthor()->removePost($post);
            $post->getAuthor()->save();
        }
        foreach ($reviews as $review){
            $review->getAuthor()->removeReview($post);
            $review->getAuthor()->save();
        }
        $article->delete();
    }
    public function editTopicOfTheArticle(Article $article, Topic $topic){
        $article->getTopic()->removeArticle($article);
        $article->getTopic()->save();
        $article->setTopic($topic);
        $topic->addArticle($article);
        $topic->save();
        $article->save();
    }
    public function editTitleOfTheArticle(Article $article, $title){
        $article->setTitle($title);
        $article->save();
    }
    public function editTextOfTheArticle(Article $article, $text){
        $article->setText($text);
        $article->save();
    }
}