<?php

    // Procesamiento del post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // eliminar espacios del formulario
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number = trim($_POST["number"]);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        // Validador de datos
        if ( empty($name) OR empty($subject) OR empty($number) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

 
        $recipient = "admin@example.com";

        //construccion del contenido.
        $email_content = "Full Name: $name\n";
        $email_content .= "Phone Number: $number\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Message:\n$message\n";

        // añadidor de formato.
        $email_headers = "New Contact From: $name <$email>";

        // envío de correo.
        if (mail($recipient, $email_headers, $email_content)) {
            // error 200
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            //error 500
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        //error de conexion
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>

