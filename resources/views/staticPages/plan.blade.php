@extends ('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
  <article class="p-12 mx-auto">
    <h2 class="font-grands text-center my-6 pb-6 text-3xl">Plan du Site</h2>
      <ul>
        <li class="font-body text-center my-6 pb-2"><a href="/">Accueil</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/connexion">Connexion</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/inscription">Inscription</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/associations">Associations Partenaires</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/animaux">Découvrez nos Animaux</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/a-propos">Qui sommes-nous ?</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/faq">Foire Aux Questions</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/devenir-famille-d-accueil">Devenir Famille d'Accueil</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/infos-legales">Informations Légales</a></li>
        <li class="font-body text-center my-6 pb-2"><a href="/rgpd">Protection des données - RGPD</a></li>
        <li class="flex font-body justify-center my-6 pb-2"><a href="/plan">Plan du site</a><p class="font-bold">&nbsp;&nbsp;(vous êtes ici)</p></li>
        <li class="font-body text-center my-6 pb-2"><a href="/contact">Contact</a></li>
      </ul>
  </article>
</main>
@endsection
