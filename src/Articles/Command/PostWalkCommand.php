<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.9.17
 * Time: 16:26
 */

namespace Articles\Command;

use Articles\Model\Model\System;
use Articles\Model\Model\Webmaster;
use Articles\Service\PostService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostWalkCommand extends SystemCommand
{
    protected function configure()
    {
        $this->setName("articles:postWalk");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = PostService::getInstance($this->createSystem());
        $posts = $service->getPosts();
        foreach ($posts as $post){
            $output->writeln($post->getId());
            $output->writeln("Article: ".$post->getArticle()->getId());
            $output->writeln("Author: ".$post->getAuthor()->getId());
            $output->writeln($post->getText());
        }
    }
}