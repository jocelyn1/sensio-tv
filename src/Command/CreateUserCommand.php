<?php

namespace App\Command;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create:user';

    protected $entityManager;

    protected $encoderPassword;

    public function __construct(UserPasswordEncoderInterface $encoderPassword, EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->encoderPassword = $encoderPassword;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a user in BD')
            ->addOption('email', 'u', InputOption::VALUE_REQUIRED)
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED)
            ->setHelp(<<<HELP
    Ex: app:create:user -u email -p password
HELP
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('User creation');

        if (!$email = $input->getOption('email')) {
            $email = $io->ask('Email ');
        }

        if (!$password = $input->getOption('password')) {
            do {
                $password = $io->askHidden('Password ');
                $passwordConfirmation = $io->askHidden('Password (confirmation)');

                if ($password !== $passwordConfirmation) {
                    $io->error('Passwords do not match');
                }

            } while ($password !== $passwordConfirmation);
        }

        try {
            $user = new User();
            $user->setEmail($email);
            $user->setPassword(
                $this->encoderPassword->encodePassword($user, $password)
            );
            $user->setBirthday(DateTimeImmutable::createFromFormat('Y-m-d', '1994-03-09'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        $io->success('User successfully registered');

        return Command::SUCCESS;
    }
}
