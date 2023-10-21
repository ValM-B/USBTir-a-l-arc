<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
	private $mailer;
	private $adminMail;

	public function __construct(MailerInterface $mailer, $adminMail){
		$this->mailer = $mailer;
		$this->adminMail = $adminMail;
	}

	/**
	 * Send an email to a user
	 *
	 * @param string $userMail user who receive the email
	 * @param string $subject subject of the email
	 * @param string $template template twig
	 * @param array $context array of cariables for the template
	 * @return void
	 */
	public function sendToUser(string $userMail, string $subject, string $template, array $context){
			$email = (new TemplatedEmail())
            ->from($this->adminMail) //compte mailjet
            ->to($userMail)
            ->subject($subject)
            
            ->htmlTemplate($template)
            ->context($context);

            $this->mailer->send($email);
	}
}