@component('mail::message')
# Informations sur {{$UsernameClient}}
<br/>

<br/>
  Vous avez Accepter avec succes la demande de location du client {{$UsernameClient}}
  a propos de l'objet {{$NomObjet}}.
  <br/>

  <br/>
  Voici quelque Information a propos du client :
  <br/>

    Nom : {{$NomClient}}
  <br/>

    Prénom :{{$PrenomClient}}
  <br/>

  Note du Client :{{$NoteClient}}
  <br/>

    Email : {{$EmailClient}}
  <br/>

  Addresse : {{$AdresseClient}}
  <br/>

  Tel : {{$TelClient}}
  <br/>

  <br/>
  Voici quelque Information a propos des dates de locations :
  <br/>

    Début de location : {{$StartDate}}
  <br/>

    Fin de location : {{$EndDate}}
  <br/>

  <br/>
Cordialement,<br>


@endcomponent
