<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 11:00
 */

namespace Articles\Command;

use Articles\Model\Exception\NoSuchUserException;
use Articles\Model\Model\ActiveUser;
use Articles\Model\Model\User;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewUserProfileCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:viewUserProfile")->addArgument("userID", InputArgument::REQUIRED, "ID of the user")->
        addArgument("type", InputArgument::REQUIRED, "Type of the user (u = User, au = ActiveUser, ad = Administrator,
        w = Webmaster)");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $id = intval($input->getArgument("userID"));
            $className = "Articles\\Model\\Model\\".LogInCommand::$array[$input->getArgument("type")];
            $user = $className::find($id);
            $output->writeln("ID: ".$user->getId());
            $output->writeln("Email: ".$user->getEmail());
            $output->writeln("Nickname: ".$user->getNickName());
            $articles = $user->getArticles();
            $posts = $user->getPosts();
            foreach ($posts as $post){
                $output->writeln("ID: ".$post->getId());
                $output->writeln("Article: ".$post->getArticle()->getTitle());
                $output->writeln($post->getText());
            }
            foreach ($articles as $article){
                $output->writeln("ID: ".$article->getId());
                $output->writeln("Topic: ".$article->getTopic()->getTitle());
                $output->writeln("Title: ".$article->getTitle());
                $output->writeln("Text: ".$article->getText());
            }
            if($user instanceof ActiveUser){
                $this->printReviewsAndTopics($user, $output);
            }
        } catch (NoSuchUserException $ex){
            $output->writeln("User with ID ".$input->getArgument("userID")." wasn't be found.");
        }
    }
    protected function printReviewsAndTopics(ActiveUser $user,  OutputInterface $output){
        $reviews = $user->getReviews();
        $topics = $user->getTopics();
        foreach ($reviews as $review){
            $output->writeln($review->getId());
            $output->writeln("Article: ".$review->getArticle()->getTitle());
            $output->writeln($review->getTitle());
            $output->writeln($review->getText());
            $output->writeln($review->getRating());
        }
        foreach ($topics as $topic){
            $output->writeln("ID: ".$topic->getId());
            $output->writeln("Title: ".$topic->getTitle());
            $output->writeln("Description: ".$topic->getDescription());
        }
    }

}