<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MailController
 *
 * @author MINA
 */
class MailController extends AppController {

    /**
     * @Route("/send_mail")
     * @Template
     */
    public function sendMailAction($name = 'aa@yahoo.com') {
        $message = \Swift_Message::newInstance()
                //  $message = new \Swift_Message('Hello Email')
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody(
                $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                         'Mail/registration.html.twig', array('name' => $name)
                ), 'text/html'
                )
        /*
         * If you also want to include a plaintext version of the message
          ->addPart(
          $this->renderView(
          'Emails/registration.txt.twig',
          array('name' => $name)
          ),
          'text/plain'
          )
         */
        ;
        $this->get('mailer')->send($message);

        return array();
    }

}
