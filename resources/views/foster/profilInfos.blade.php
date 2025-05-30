@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
	<h2 class="font-grands text-3xl text-center my-2 py-6">Bienvenue sur votre espace personnel</h2>
  <div class="flex flex-col content-center justify-center mx-auto mb-4 w-[80%]">

    <nav class="flex flex-wrap justify-center md:justify-start">
      <ul class="flex flex-wrap-reverse gap-x-2 mx-3 justify-center font-semibold md:justify-start md:ml-10 text-xl">
        <li><a href="/famille/profil" tabindex="0"><button id="dashbtn-1" class="dashbtn dashbtn-active" tabindex="-1">Mon profil</button></a></li>
        <li><a href="/famille/profil/demandes" tabindex="0"><button id="dashbtn-2" class="dashbtn" tabindex="-1">Demandes</button></a></li>
      </ul>
      <div class="mx-2 grow w-[90%] h-2 bg-accents1-dark rounded-t-lg"></div>
    </nav>

    <div class="font-body bg-zoning rounded-lg shadow mb-4">

      <section class="flex flex-wrap justify-center" id="dashboard-container">
        <h3 class="font-grands text-3xl text-center my-2 pt-5 w-full">Mon profil</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
                <li class="flash-notice font-grands font-base text-accents1 text-center">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
          <p class="flash-notice font-grands font-base text-accents1 text-center">{{ session('error') }}</p>
        </div>
        @endif

        <form class="flex flex-col flex-wrap content-center justify-around text-texte w-full" action="" method="POST">
        @csrf
          <fieldset class="w-[60%] font-body rounded-lg shadow my-2 py-5">
            <legend class="text-center">Mes informations&nbsp;<span tabindex="0" class="material-symbols-outlined">edit</span></legend>

            <div class="mx-auto p-2">
              <label class="text-center w-full" for="prenom">Prénom</label>
              <input class="block w-full" type="text" id="prenom" name="prenom" value="{{ $famille->prenom }}" disabled>
            </div>
            <div class="mx-auto p-2">
              <label class="text-center w-full" for="nom">Nom</label>
              <input class="block w-full" type="text" id="nom" name="nom" value="{{ $famille->nom }}" disabled>
            </div>
          </fieldset>

          <fieldset class="font-body rounded-lg shadow my-2 py-5">
            <legend class="text-center">Mon accueil&nbsp;<span tabindex="0" class="material-symbols-outlined">edit</span></legend>

              <div class="mx-auto p-2">
                <label class="text-center w-full" for="hebergement">Type</label>
                <input class="block w-full" type="text" id="hebergement" name="hebergement" value="{{ $famille->hebergement }}" disabled>
              </div>

              <div class="mx-auto p-2">
                <label class="text-center w-full" for="terrain">Terrain</label>
                <input class="block w-full" type="text" id="terrain" name="terrain" value="{{ $famille->terrain }}" disabled>
              </div>

              <div class="mx-auto p-2">
                <label class="text-center w-full" for="rue">Rue</label>
                <input class="block w-full" type="text" id="rue" name="rue" value="{{ $famille->rue }}" disabled>
              </div>

              <div class="mx-auto p-2">
                <label class="text-center w-full" for="commune">Commune</label>
                <input class="block w-full" type="text" id="commune" name="commune" value="{{ $famille->commune }}" disabled>
              </div>

              <div class="mx-auto p-2">
                <label class="text-center w-full" for="code_postal">Code Postal</label>
                <input class="block w-full" type="text" id="code_postal" name="code_postal" pattern="^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$" value="{{ $famille->code_postal }}" disabled>
              </div>
          </fieldset>

          <button id="validate" class="hidden w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Valider les modifications</button>
        </form>
        <form class="flex flex-col flex-wrap content-center justify-around text-texte" action="/famille/profil/delete" onsubmit="return confirm('Voulez-vous vraiment supprimer votre profil ? Cette action est irréversible !')">
        @csrf
          <button id="deleteAccount" class="w-[60%] mx-auto my-3 py-2 px-4 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Supprimer mon profil</button>
          <p class="text-center w-full">ATTENTION ! Cette suppression est définitive !</p>
        </form>
      </section>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/editInputs.js') }}" async></script>
@endpush
