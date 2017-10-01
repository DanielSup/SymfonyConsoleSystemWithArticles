<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24.9.17
 * Time: 14:24
 */

require "autoloader.php";
require "../vendor/autoload.php";

use Articles\Model\Model;
use Articles\Model\Exception\NoSuchPostException;
use Articles\Service;

LogSettings::setLogging();
$user1 = new Model\User("email@email.cz","nickname1");
$user2 = new Model\User("email2@email.cz","nickname2");
$user3 = new Model\ActiveUser("email3@email.cz","nickname3");
$system = Model\System::getInstance(new Model\Webmaster("email@seznam.cz","nick"));
$service0 = Service\TopicService::getInstance($system);
$service1 = Service\ArticleService::getInstance($system);
$service2 = Service\PostService::getInstance($system);
$topic = $service0->addTopic($user3, "Topic 1", "desciption of topic 1");
$topic2 = $service0->addTopic($user3, "Topic 2", "desciption of topic 2");
$service1->addArticle($topic, $user3, "Article 1", "desciption of article 1");
$service1->addArticle($topic2, $user2, "Article 2", "desciption of article 2");
$article = Model\Article::find(6);
$article2 = Model\Article::find(7);
$service2->addPost($user1, $article, "Post 1");
$service2->addPost($user2, $article2, "Post 2");
$service2->addPost($user3, $article2, "Post 3");
$service2->addPost($user3, $article, "Post 4");
$service2->addPost($user2, $article2, "Post 5");
$service2->addPost($user1, $article2, "Post 6");
$service2->addPost($user3, $article, "Post 7");
$service2->addPost($user1, $article2, "Post 8");
Model\Post::find(23);