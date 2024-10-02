<?php
namespace App\Controller;
use App\Service\SMSPartnerAPI;
use Twilio\Rest\Client;
use Twilio\Http\CurlClient;
use Twilio\Exceptions\EnvironmentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Bridge\Twilio\TwilioOptions;
use Symfony\Component\Notifier\Exception\TransportException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('/sms')]
    public function MessageEnvoye(TexterInterface $texter): Response
    {   
        
        // $smspartner = new SMSPartnerAPI(false);
        // $result = $smspartner->checkCredits('?apiKey=b08a8c760cc4347ebf4f81c2ea3434d162dac0b0');

        // // $fields = array(
        // //     "apiKey"=>"b08a8c760cc4347ebf4f81c2ea3434d162dac0b0",
        // //     "phoneNumbers"=>"+261349559374",
        // //     "message"=>"coucou toi",
        // //     "sender" => "DEMOSMS",            
        
        // // );
        // $result = $smspartner->sendSms($fields);
        // var_dump($result);

        $twilioSid = 'AC514e22dbe8acf9cfcd5fe49995569f7a'    ;
        $twilioToken ='a17c06410af669f2c22ad8048dc0c643';

        $twilio = new Client($twilioSid,$twilioToken);

        $message = $twilio->messages
                            ->create(
                                "Whatsapp:+1484749871",
                                array(
                                    "body"=>"Greeting",
                                    "from"=>"whatsapp:14847498710"
                                )
                                );
        

       return new Response('ok');
    }
}


?>