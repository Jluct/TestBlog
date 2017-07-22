<?php

namespace Jluct\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class JbUserCreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('jb:user:create:admin')
            ->setDescription('Creates a user with administrator role')
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Username')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password', 123456)
            ->addOption('email', 'm', InputOption::VALUE_REQUIRED, 'Email')
            ->addOption('active', 'a', InputOption::VALUE_OPTIONAL, 'Active user', true);
    }

    /**
     * Created admin user
     * Example:
     * php bin/console jb:user:create:admin -u admin -p 123456 -m admin@mail.ru -a true
     * php bin/console jb:user:create:admin --username=admin --password=123456 --email=admin@mail.ru --active=true
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $this->getContainer()->get('jluct_blog.user.create');
        $data = [];

        $data['username'] = $input->getOption('username');
        $data['password'] = $input->getOption('password');
        $data['email'] = $input->getOption('email');
        $data['active'] = $input->getOption('active') ? 1 : 0;
        $data['role'] = 'ROLE_ADMIN';

        $service->createUser($data);

        $output->writeln('<info>User created</info>');
        return 0;
    }

}
