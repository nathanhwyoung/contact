<?php

    // makes libraries and classes available to the application

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    // starts the $_SESSION superglobal variable

    session_start();

    //checks to see if the $_SESSION variable is empty at the specified key
    // if it is empty, creates an array at that key

    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    // creates a new Silex\Application object

    $contact_app = new Silex\Application();

    // debugging

    $contact_app['debug'] = true;

    // makes the twig library available to the application and tells twig to
    // look for out template in the views folder

    $contact_app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // calls the get $method on the $contact_app object and receives a URL path
    // as its first argument, and a function that gives us access to the
    // $contact_app variable, then returns the $contact_app object (using twig)
    // to call the render method (which receives a file path that contains the
    // twig template and an array that contains the contact list)

    $contact_app->get("/", function() use ($contact_app) {
        return $contact_app['twig']->render('contacts.html.twig', array('contacts' => Contact::getAll()));
    });

    // calls the post method on the $contact_app object and receives a URL path
    // as its first argument, and a function that gives us access to the
    // $contact_app variable. the method then creats a new contact object based
    // on the date it receives from the form, and then saves (or pushes) the
    // new object onto the $_SESSION array. then the method returns the
    // $contact_app object (using twig) to call the render method (which
    // receives a file path that contains the twig template and an array that
    // contains the new contact object, which is added to the list)

    $contact_app->post("/contacts", function() use ($contact_app) {
        $new_contact = new Contact($_POST['add_name'], $_POST['add_number'], $_POST['add_address']);
        $new_contact->save();
        return $contact_app['twig']->render('create_contact.html.twig', array('newcontact' => $new_contact));
    });

    $contact_app->post("/delete_contacts", function() use ($contact_app) {
        Contact::deleteAll();
        return $contact_app['twig']->render('delete_contacts.html.twig');
    });

    return $contact_app;

?>
