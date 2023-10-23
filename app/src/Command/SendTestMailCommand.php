<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:send-test-mail',
    description: 'Send test mail',
)]
class SendTestMailCommand extends Command
{
    private MailerInterface $mailer;

    public function __construct(
        MailerInterface $mailer
    ) {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('to', InputArgument::OPTIONAL, 'to email address')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $to = $input->getArgument('to') ?? 'admin@localhost';

        $io->note(sprintf('Send test email to %s', $to));

        $email = (new Email())
            ->to($to)
            ->subject('YasbiSaEAB test email')
            ->text('Hello world from YasbiSaEAB!');

        $this->mailer->send($email);
        $io->success('Is sent test email.');

        return Command::SUCCESS;
    }
}
