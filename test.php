<?php

$name = "imageTest";
$phoneNumber = "123123";

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


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/m8/feeds/contacts/default/full");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '. $_COOKIE['token'],
    'content-type: application/atom+xml, charset=UTF-8; type=feed'
    ));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $xmlToSend );
  $response = curl_exec($ch);
  curl_close($ch);


   $xmlContact = simplexml_load_string($response);
        $xmlContact->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
        $xmlContactsEntry = $xmlContact;
        $contactDetails = array();
        $contactDetails['id'] = (string) $xmlContactsEntry->id;
        $contactDetails['name'] = (string) $xmlContactsEntry->title;
        foreach ($xmlContactsEntry->children() as $key => $value) {
            $attributes = $value->attributes();
            if ($key == 'link') {
                if ($attributes['rel'] == 'edit') {
                    $contactDetails['editURL'] = (string) $attributes['href'];
                } elseif ($attributes['rel'] == 'self') {
                    $contactDetails['selfURL'] = (string) $attributes['href'];
                }
            }
        }
        $contactGDNodes = $xmlContactsEntry->children('http://schemas.google.com/g/2005');
        foreach ($contactGDNodes as $key => $value) {
            $attributes = $value->attributes();
            if ($key == 'email') {
                $contactDetails[$key] = (string) $attributes['address'];
            } else {
                $contactDetails[$key] = (string) $value;
            }
        }

$
$putURL = 'https://www.google.com/m8/feeds/m8/feeds/photos/media/default/contactId'.$contactDetails['id'];

?>
