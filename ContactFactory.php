<?php
require_once __DIR__.'/vendor/autoload.php';
use GuzzleHttp\Client;

abstract class ContactFactory
{
    public static function getAll($token)
    {

$client = new \GuzzleHttp\Client();

$response = $client->request('GET', 'https://www.google.com/m8/feeds/contacts/default/full?max-results=10000&updated-min=2007-03-16T00:00:00', [
    'headers' => [
        'Authorization'     => 'Bearer '.$token,
         // 'GData-Version': '3.0'
    ]
]);

$body = $response->getBody()->getContents();

        // $xmlContacts = simplexml_load_string($body);
        // $xmlContacts->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
        // $contactsArray = array();
        // foreach ($xmlContacts->entry as $xmlContactsEntry) {
        //     $contactDetails = array();
        //     $contactDetails['id'] = (string) $xmlContactsEntry->id;
        //     $contactDetails['name'] = (string) $xmlContactsEntry->title;
        //     $contactDetails['content'] = (string) $xmlContactsEntry->content;
        //     foreach ($xmlContactsEntry->children() as $key => $value) {
        //         $attributes = $value->attributes();
        //         if ($key == 'link') {
        //             if ($attributes['rel'] == 'edit') {
        //                 $contactDetails['editURL'] = (string) $attributes['href'];
        //             } elseif ($attributes['rel'] == 'self') {
        //                 $contactDetails['selfURL'] = (string) $attributes['href'];
        //             } elseif ($attributes['rel'] == 'http://schemas.google.com/contacts/2008/rel#edit-photo') {
        //                 $contactDetails['photoURL'] = (string) $attributes['href'];
        //             }
        //         }
        //     }
        //     $contactGDNodes = $xmlContactsEntry->children('http://schemas.google.com/g/2005');
        //     foreach ($contactGDNodes as $key => $value) {
        //         switch ($key) {
        //             case 'organization':
        //                 $contactDetails[$key]['orgName'] = (string) $value->orgName;
        //                 $contactDetails[$key]['orgTitle'] = (string) $value->orgTitle;
        //                 break;
        //             case 'email':
        //                 $attributes = $value->attributes();
        //                 $emailadress = (string) $attributes['address'];
        //                 $emailtype = substr(strstr($attributes['rel'], '#'), 1);
        //                 $contactDetails[$key][] = ['type' => $emailtype, 'email' => $emailadress];
        //                 break;
        //             case 'phoneNumber':
        //                 $attributes = $value->attributes();
        //                 //$uri = (string) $attributes['uri'];
        //                 $type = substr(strstr($attributes['rel'], '#'), 1);
        //                 //$e164 = substr(strstr($uri, ':'), 1);
        //                 $contactDetails[$key][] = ['type' => $type, 'number' => $value->__toString()];
        //                 break;
        //             default:
        //                 $contactDetails[$key] = (string) $value;
        //                 break;
        //         }
        //     }
        //     $contactsArray[] = new Contact($contactDetails);
        // }
        return $body;
    }

        public static function create($token, $name, $phoneNumber, $emailAddress, $customConfig = NULL)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = true;
        $entry = $doc->createElement('atom:entry');
        $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:atom', 'http://www.w3.org/2005/Atom');
        $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:gd', 'http://schemas.google.com/g/2005');
        $entry->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:gd', 'http://schemas.google.com/g/2005');
        $doc->appendChild($entry);
        $title = $doc->createElement('title', $name);
        $entry->appendChild($title);
        $email = $doc->createElement('gd:email');
        $email->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
        $email->setAttribute('address', $emailAddress);
        $entry->appendChild($email);
        $contact = $doc->createElement('gd:phoneNumber', $phoneNumber);
        $contact->setAttribute('rel', 'http://schemas.google.com/g/2005#work');
        $entry->appendChild($contact);
        $note = $doc->createElement('atom:content', $note);
        $note->setAttribute('rel', 'http://schemas.google.com/g/2005#kind');
        $entry->appendChild($note);
        $xmlToSend = $doc->saveXML();




// $response = $client->request('POST', '', [
//     'body' => $xmlToSend,
//     'headers' => [
//         'Authorization'     => 'Bearer '. $token,
//         'content-type' => 'application/atom+xml, charset=UTF-8; type=feed',
//         'GData-Version' =>: '3.0'
//     ]
// ]);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/m8/feeds/contacts/default/full");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '. $token,
    'content-type: application/atom+xml, charset=UTF-8; type=feed'
    ));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $xmlToSend );
  $result = curl_exec($ch);
  curl_close($ch);

  $file = '/tmp/response.xml';

$current = file_get_contents($file);
$current .= $result;

file_put_contents($file, $current);

         return "ok";

    }


}
