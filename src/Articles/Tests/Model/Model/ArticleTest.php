<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1.10.17
 * Time: 8:26
 */

namespace Articles\Tests\Model\Model;

use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\Article;
use Articles\Model\Model\Topic;
use Articles\Model\Model\User;

class ArticleTest  extends \PHPUnit_Framework_TestCase
{
    /** @var  Article */
    protected $article;
    /** @var  Topic */
    protected static $topic;
    /** @var  User */
    protected static $user;
    /** @var  ActiveUser */
    protected static $activeUser;
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->article = new Article(self::$topic, self::$user, "Title of the article", "Description of the article");
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$user = new User("email@seznam.cz", "nickname");
        self::$activeUser = new ActiveUser("email@seznam.cz", "nickname");
        self::$topic = new Topic(self::$activeUser, "Title", "Description");
    }
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function testEmptyArticle(){
        $this->assertEmpty($this->article->getPosts());
        $this->assertEmpty($this->article->getReviews());
        $this->assertEquals(self::$activeUser, $this->article->getTopic()->getAuthor());
        $this->assertEquals(self::$user, $this->article->getAuthor());
    }

}