<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:09
 */

namespace Articles\Service;


use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Topic;

class TopicService
{
    use SingletonTrait;
    public function getTopics(){
        return Topic::walk();
    }
    public function addTopic(ActiveUser $author, $title, $desciption){
        $topic = new Topic($author, $title, $desciption);
        $author->addTopic($topic);
        $this->system->addTopic($topic);
        $topic->save();
        return $topic;
    }
    public function removeTopic(Topic $topic){
        $topic->getAuthor()->removeTopic($topic);
        $articleService = ArticleService::getInstance($this->system);
        $articles = $topic->getArticles();
        foreach ($articles as $article){
            $articleService->removeArticle($article);
        }
        $topic->getAuthor()->save();
        $this->system->removeTopic($topic);
    }
    public function editTitleOfTheTopic(Topic $topic, $title){
        $topic->setTitle($title);
        $topic->save();
    }
    public function editDescriptionOfTheTopic(Topic $topic, $description){
        $topic->setDescription($description);
        $topic->save();
    }
}