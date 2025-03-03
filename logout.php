<?php
session_start(); // for å session som brukeren sin konto er lagret i.
session_destroy(); // avslutter Session for at kontoen til brukeren koble fra Session.
header('Location: index.html'); // Sender brukeren til index.html.
?>