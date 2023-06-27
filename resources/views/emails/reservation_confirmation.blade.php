<!DOCTYPE html>
<html>
<head>
    <title>Conferma prenotazione</title>
</head>
<body>
<h1>Conferma prenotazione</h1>
<p>Gentile cliente,</p>
<p>La sua prenotazione è stata accettata. Grazie per aver scelto il nostro servizio.</p>
<p>Dettagli prenotazione:</p>
<ul>
    <li>Data: {{ $reservation->date }}</li>
    <li>Ora: {{ $reservation->time }}</li>
    <!-- Aggiungi altri dettagli che desideri visualizzare nell'email -->
</ul>
<p>Restiamo a sua disposizione per ulteriori informazioni.</p>
<p>Cordiali saluti,</p>
<p>Il tuo team di prenotazioni</p>
</body>
</html>
