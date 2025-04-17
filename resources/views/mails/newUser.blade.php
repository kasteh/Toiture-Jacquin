<div>
    Bonjour,
    <br>
    <br>
    Vous avez été inscrit sur {{env('APP_URL')}}
    <br>
    <br>
    Voici votre mot de pass : <strong>{{$data['password']}}</strong>
    <br>
    <br>
    Pour vous connectez veuillez entrer votre adresse email ainsi que votre mot de passe ici dans le formulaire present sur ce lien :
    <br>
    <br>
    <a href="{{env('APP_URL')}}/admin">{{env('APP_URL')}}/admin</a>
    <br>
    <br>
    N'oubiez pas de changer votre mot de passe une fois connecté
    <br>
    <br>
    Bien à vous.
</div>