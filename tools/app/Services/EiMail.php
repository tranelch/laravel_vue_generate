<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Services\LfMailable;
use App\Jobs\SendEmailJob;
use App\Models\LoadSentEmail;
use Carbon\Carbon;

class LfMail
{
    /**
     * Send an email
     *
     * @param array $to - Array of email addresses
     * @param string $subject - Email subject
     * @param string $template - Email template to be used
     * @param object $data - Data to be passed to the template
     * @param string|null $replyToAddress - If null, uses default from address
     * @param string|null $fromName - If null, uses default from name
     * @param array|null $attachments - Array of attachments (keys 'path' and 'mime')
     * @param array|null $cc - Array of cc addresses
     *
     * @return ?boolean
     *
     * @throws \Exception
     */
    public static function send(array $to, string $subject, string $template, object $data, string $replyToAddress = null, string $fromName = null, array $attachments=null, array $cc=null): ?bool {
        if (empty($to)) {
            throw new \Exception('No recipients were specified, no email was sent.');
        }

        if (empty($subject) || empty($template) || empty($data)) {
            throw new \Exception('The email failed to send due to a programming error.');
        }

        $to = self::setTo($to, $cc);
        $failedEmails = [];

        foreach ($to as $toItem) {
            $mail = self::buildMail($subject, $template, $data, $replyToAddress, $fromName, $attachments);
            try {
                Mail::to([$toItem])->send($mail);
            } catch (\Exception $e) {
                $failedEmails[] = $toItem . '(' . $e->getMessage() . ')';
            }
        }

        if (!empty($failedEmails)) {
            throw new \Exception('The following emails failed to send: ' . implode(', ', $failedEmails));
        }

        return true;
    }

    public static function queue(array $to, string $subject, string $template, object $data, string $replyToAddress = null, string $fromName = null, array $attachments=null, array $cc=null): ?bool {
        if (empty($to) || empty($subject) || empty($template) || empty($data)) {
            return false;
        }

        $to = self::setTo($to, $cc);

        foreach ($to as $toItem) {
            $mail = self::buildMail($subject, $template, $data, $replyToAddress, $fromName, $attachments);
            dispatch(new SendEmailJob([$toItem], $mail));
        }

        return true;
    }

    /**
     * Send a load-related email
     *
     * @param int $loadId - Load ID
     * @param string $trigger - Trigger for the email
     * @param string $sentTo - Text description of whom email was sent to
     * @param array $to - Array of email addresses
     * @param string $subject - Email subject
     * @param string $template - Email template to be used
     * @param object $data - Data to be passed to the template
     * @param string|null $replyToAddress - If null, uses default from address
     * @param string|null $fromName - If null, uses default from name
     * @param array|null $attachments - Array of attachments (keys 'path' and 'mime')
     * @param array|null $cc - Array of cc addresses
     *
     * @return ?boolean
     *
     * @throws \Exception
     */
    public static function sendLoadEmail(int $loadId, string $trigger, string $sentTo, array $to, string $subject, string $template, object $data, string $replyToAddress = null, string $fromName = null, array $attachments = null, array $cc = null): ?bool {
        //log email
        LoadSentEmail::create(['load_id' => $loadId, 'trigger' => $trigger, 'sent_to' => $sentTo]);
        //send
        return self::send($to, $subject, $template, $data, $replyToAddress, $fromName, $attachments, $cc);
    }

    public static function queueLoadEmail(int $loadId, string $trigger, string $sentTo, array $to, string $subject, string $template, object $data, string $replyToAddress = null, string $fromName = null, array $attachments = null, array $cc = null): ?bool {
        //log email
        LoadSentEmail::create(['load_id' => $loadId, 'trigger' => $trigger, 'sent_to' => $sentTo]);

        //queue
        return self::queue($to, $subject, $template, $data, $replyToAddress, $fromName, $attachments, $cc);
    }

    protected static function setTo(array $to, array $cc = null) {
        if (!empty($cc)) {
            $to = array_merge($to, $cc);
        }
        // hard code for staging
        if (env('APP_ENV') === 'staging') {
            $to = [config('mail.system_admin_email')];
        }

        return $to;
    }

    protected static function buildMail(string $subject, string $template, object $data, string $replyToAddress = null, string $fromName = null, array $attachments = null) {
        $mail = new LfMailable($data);
        $mail
            ->from((config('mail.from.address')), (!empty($fromName) ? $fromName : config('mail.from.name')))
            ->replyTo($replyToAddress, $fromName)
            ->subject($subject)
            ->view($template);

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $mail->attach($attachment['path'], ['mime'=>$attachment['mime']]);
            }
        }

        return $mail;
    }

}