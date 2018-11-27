<?php

namespace App\Command;
use App\Command\Service\ManagerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AgeCalculatorCommand extends Command
{
    protected static $defaultName = 'app:age:calculator';

    private $managerService;

    /**
     * AgeCalculatorCommand constructor.
     * @param $managerService
     */
    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Calculates person\'s age based on entered date and determines if he / she is adult. ')
            ->addArgument('birthdate', InputArgument::REQUIRED, 'Date of birth')
            ->addOption('adult', null, InputOption::VALUE_NONE, 'Check if person is an adult.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $birthdate = $input->getArgument('birthdate');

        if ($birthdate) {
            $io->note($this->managerService->printAge($birthdate));
        }

        $adultMessage = "Am I and adult?   ----  %s !!";

        if ($input->getOption('adult')) {
            if($this->managerService->checkIfAdult($birthdate))
            {
                $io->success(sprintf($adultMessage, "YES"));
            }
            else
            {
                $io->error(sprintf($adultMessage, "NO"));
            }
        }

    }
}
