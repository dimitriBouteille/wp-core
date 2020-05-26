<?php

namespace Dbout\WpCore\Mail;

/**
 * Class AbstractSwiftMail
 * @package Dbout\WpCore\Mail
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
abstract class AbstractMail
{

    /**
     * @var \Swift_Message
     */
    protected $message;

    /**
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    /**
     * AbstractMail constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Init class
     */
    protected function init(): void
    {
        $this->message = new \Swift_Message();
        $transporter = apply_filters('dbout_mail_config', new \Swift_SmtpTransport());
        $this->swiftMailer = new \Swift_Mailer($transporter);
    }

    /**
     * @param string $subject
     * @return $this
     */
    protected function subject(string $subject): self
    {
        $this->message->setSubject($subject);
        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    protected function from(string $email, string $name = null): self
    {
        $this->message->setFrom($email, $name);
        return $this;
    }

    /**
     * @param $email
     * @param string|null $name
     * @return $this
     */
    protected function setTo($email, string $name = null): self
    {
        $this->message->setTo($email, $name);
        return $this;
    }

    /**
     * @param string|array $email
     * @param string|null $name
     * @return $this
     */
    protected function bbc($email, string $name = null): self
    {
        $this->message->addBcc($email, $name);
        return $this;
    }

    /**
     * @param string $body
     * @param string|null $charset
     * @return $this
     */
    protected function htmlBody(string $body, string $charset = null): self
    {
        $this->message->setBody($body, 'text/html', $charset);
        return $this;
    }

    /**
     * @param string $body
     * @param string|null $charset
     * @return $this
     */
    protected function textBody(string $body, string $charset = null): self
    {
        $this->message->setBody($body, 'text/plain', $charset);
        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        // Build message
        $this->build();

        // And send message
        $totalRecipients = $this->swiftMailer->send($this->message);
        return $totalRecipients > 0;
    }

    /**
     * Build body message
     * @return void
     */
    abstract protected function build(): void;
}
