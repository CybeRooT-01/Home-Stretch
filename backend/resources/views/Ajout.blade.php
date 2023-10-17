<x-mail::message>
Bienvenu chere {{$poste}} <br>
votre login est : {{$login}} <br>
votre mot de passe est : {{$password}}

<x-mail::button :url="''">
Modifier votre mot de passe
</x-mail::button>

Cordialement,<br>
La direction pedagogique
</x-mail::message>
