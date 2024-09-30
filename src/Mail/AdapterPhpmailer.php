<?php

namespace bossanova\Mail;

use PHPMailer\PHPMailer\PHPMailer;

class AdapterPhpmailer implements MailService
{
    /**
     * Debug
     *
     * @var $debug
     */
    public $debug = false;

    /**
     * Sendmail instance
     *
     * @var $instance
     */
    public $instance = null;

    public function login(array $config)
    {
        // Composer autoloader loads the class into memory even
        // if the PHPMailer is never used. If composer is not
        // used, need to load the class manually.

        $this->instance = new PHPMailer();

        $this->instance->CharSet = "UTF-8";

        if (isset($config['MS_CONFIG_HOST'])) {
            $this->instance->Mailer = "smtp";
            $this->instance->Host = $config['MS_CONFIG_HOST'];
            $this->instance->Port = $config['MS_CONFIG_PORT'];
            if ($config['MS_CONFIG_USER']) {
                $this->instance->SMTPAuth = true;
                $this->instance->Username = $config['MS_CONFIG_USER'];
                $this->instance->Password = $config['MS_CONFIG_PASS'];

                if (isset($config['MS_CONFIG_AUTH'])) {
                    $this->instance->AuthType = $config['MS_CONFIG_AUTH'];
                }
            }

            $this->instance->SMTPDebug = false;
        }
    }

    public function addTo($email, $name = null)
    {
        $this->instance->addAddress($email, $name);
    }

    public function addAddress($email, $name = null)
    {
        $this->instance->addAddress($email, $name);
    }

    public function setFrom($email, $name = null)
    {
        $this->instance->setFrom($email, $name);
    }

    public function setReplyTo($replyTo)
    {
        $this->instance->addReplyTo($replyTo);
    }

    public function setSubject($subject)
    {
        $this->instance->Subject = $subject;
    }

    public function setHtml($html)
    {
        $this->instance->msgHTML($html);
    }

    public function setText($text)
    {
        $this->instance->msgAltBody = $text;
    }

    public function addAttachment($path, $name)
    {
        $this->instance->addAttachment($path, $name);
    }

    public function setDebug($value = false)
    {
        $this->instance->SMTPDebug = $value;
        $this->instance->Debugoutput = 'html';
    }

    public function send()
    {
        $this->instance->send();
    }

    public function error()
    {
        return $this->instance->ErrorInfo;
    }
}
