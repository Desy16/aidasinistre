<?php

namespace App\Notification;
use Twig\Environment;
use App\Entity\Contact;
use App\Entity\Association;


class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailler;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailler, Environment $renderer)
    {
        $this->mailler = $mailler;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        # code... Le nom de l'association concerné
        # L'adresse qui sert à l'envoi
        # L'adresse à qui est destiné l'email
        # A qui nous allons répondre
        # Le contenu de notre email
        # . $contact->getAssociation()->getNom() L'association associé à notre contact

        $message = (new \Swift_Message('Association : ' . $contact->getAssociation()->getName()))
                    ->setFrom('noreply@aidasinistre.fr')
                    ->setTo('contact@association.fr')
                    ->setReplyto($contact->getEmail())
                    ->setBody($this->renderer->render('emails/contact.html.twig', [
                        'contact' => $contact
                    ]), 'text/html');

        $this->mailler->send($message);

    }
}
?>