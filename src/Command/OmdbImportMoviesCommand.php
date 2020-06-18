<?php

namespace App\Command;

use App\Entity\Movie;
use App\Omdb\MovieApiInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class OmdbImportMoviesCommand extends Command
{
    protected static $defaultName = 'app:omdb:import-movies';

    private $movieApi;
    private $manager;

    /**
     * @var SymfonyStyle
     */
    private $io;

    public function __construct(MovieApiInterface $movieApi, EntityManagerInterface $manager)
    {
        $this->movieApi = $movieApi;
        $this->manager = $manager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import movies from OMDb API.')
            ->addArgument('search', InputArgument::REQUIRED, 'Terms to search by title.')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Do insert in database.')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('search')) {
            $io = new SymfonyStyle($input, $output);

            $input->setArgument('search', $io->ask('Which title?'));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('Import Movies From OMDb');

        try {
            $data = $this->movieApi->search($input->getArgument('search'));
        } catch (TransportExceptionInterface $e) {
            if ($output->isDebug()) {
                $this->io->note('Transport exception: '.$e->getMessage());
            }

            $this->io->caution('No results.');

            return Command::FAILURE;
        }

        // todo handle no results

        $this->io->comment(sprintf('Found %s result(s).', $data['totalResults']));

        $result = $data['Search'];
        $choices = array_merge(array_column($result, 'Title'), ['All']);
        $choice = $this->io->choice('Would like to import those?', $choices);

        if ('All' === $choice) {
            foreach ($result as $data) {
                $movie = $this->importMovie($data);
            }
            $imported = \count($result);
        } else {
            $movie = $this->importMovie($result[array_search($choice, $choices, true)]);
            $imported = 1;
        }

        if ($input->hasOption('force')) {
            $this->manager->flush();
        }

        if ($output->isVerbose()) {
            $this->io->note('Persisted movie id: '.$movie->getId());
        }

        $this->io->success(sprintf('Done importing %s movie(s).', $imported));

        return Command::SUCCESS;
    }

    private function importMovie(array $data): Movie
    {
        $movie = $this->movieApi->get($data['imdbID']);

        if ($this->io->isVerbose()) {
            $this->io->note('Importing: '.$data['Title']);
            $this->io->table(
                ['', 'value'],
                array_map(function ($value, $key) {
                    return [$key, $value];
                }, $data, array_keys($data))
            );
        }

        $this->manager->persist($movie);

        return $movie;
    }
}
