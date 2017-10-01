<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25.9.17
 * Time: 12:12
 */

namespace Articles\Command;

use Articles\Model\Exception\NoPostsException;
use Articles\Model\Exception\NoSuchPostException;
use Articles\Model\Exception\PostNotRemovedException;
use Articles\Model\Model\Post;
use Articles\Service\PostService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemovePostCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:removePost")->addArgument("postID", InputArgument::REQUIRED, "ID of the post");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(empty(self::$user)){
            $output->writeln("You must be logged in to remove an article.");
            return;
        }
        $service = PostService::getInstance($this->createSystem());
        $id = intval($input->getArgument("postID"));
        try {
            $post = Post::find($id);
            $service->removePost($post);
        } catch(NoSuchPostException $ex){
            $output->writeln("Post with ID ".$input->getArgument("postID")." wasn't found.");
        }
    }
}