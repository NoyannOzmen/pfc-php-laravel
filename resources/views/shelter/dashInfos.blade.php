@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
  <h2 class="font-grands text-3xl text-center my-2 pt-5">Bienvenue sur votre espace personnel</h2>
  <div class="flex flex-col content-center justify-center mx-auto mb-4 w-[80%]">

    <nav class="flex flex-wrap justify-center md:justify-start">
      <ul class="flex flex-wrap-reverse gap-x-2 mx-3 justify-center font-semibold md:justify-start md:ml-10 text-xl">
        <li><a href="/association/profil" tabindex="0"><button id="dashbtn-1" class="dashbtn dashbtn-active" tabindex="-1">Profil</button></a></li>
        <li><a href="/association/profil/demandes" tabindex="0"><button id="dashbtn-2" class="dashbtn" tabindex="-1">Demandes</button></a></li>
        <li><a href="/association/profil/animaux" tabindex="0"><button id="dashbtn-3" class="dashbtn" tabindex="-1">Animaux</button></a></li>
      </ul>
      <div class="mx-2 grow w-[90%] h-2 bg-accents1-dark rounded-t-lg"></div>
    </nav>

    <div class="font-body bg-zoning rounded-lg shadow mb-4">

      <nav class="rounded-lg h-9">
        <ul class="rounded-t-lg flex h-9 content-center bg-accents2 justify-stretch font-semibold text-fond text-sm md:justify-start pl-2">
          <li class="dashsubbtn-active rounded-tl-lg block grow text-center pl-2 border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 md:rounded-none md:border-l-2 md:border-l-zoning bor"><a href="/association/profil/">Mes informations</a></li>
          <li class="block grow text-center border-r-solid border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4"><a href="/association/profil/logo">Ajouter une image</a></li>
        </ul>
      </nav>

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

        <form class="flex flex-col flex-wrap content-center md:w-[60%] justify-center text-texte" action="" method="POST">
        @csrf
          <fieldset class="shrink font-body rounded-lg shadow my-2 py-5">
            <legend class="text-center">Mon organisme&nbsp;<span tabindex="0" class="material-symbols-outlined">edit</span></legend>

            <div class="mx-auto p-2">
              <label class="text-center" for="nom">Nom</label>
              <input class="block w-full mx-auto" type="text" id="nom" name="nom" value="{{ $association->nom }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="president">Président</label>
              <input class="block w-full mx-auto" type="text" id="president" name="responsable" value="{{ $association->responsable }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="rue">Rue</label>
              <input class="block w-full mx-auto" type="text" id="rue" name="rue" value="{{ $association->rue }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="commune">Commune</label>
              <input class="block w-full mx-auto" type="text" id="commune" name="commune" value="{{ $association->commune }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="code_postal">Code Postal</label>
              <input class="block w-full mx-auto" type="text" id="code_postal" name="code_postal" pattern="^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$" value="{{ $association->code_postal }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="pays">Pays</label>
              <input class="block w-full mx-auto" type="text" id="pays" name="pays" value="{{ $association->pays }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="telephone">N° Téléphone</label>
              <input class="block w-full mx-auto" type="tel" id="telephone" name="telephone" pattern="^(0|\+33 )[1-9]([\-. ]?[0-9]{2} ){3}([\-. ]?[0-9]{2})|([0-9]{8})$" value="{{ $association->telephone }}" disabled>
            </div>

            <div class="mx-auto p-2">
              <label class="text-center" for="siret">N° SIRET</label>
              <input class="block w-full mx-auto" type="text" id="siret" name="siret" pattern="^(\d{14}|((\d{3}[ ]\d{3}[ ]\d{3})|\d{9})[ ]\d{5})$" value="{{ $association->siret }}" disabled>
            </div>

            <div class="mx-auto p-2 flex flex-wrap">
              <label class="w-full" for="site">Site Web</label>
              <input class="block w-full mx-auto" type="url" name="site" id="site" value="{{ $association->site }}"  pattern="https://.*"  disabled />
            </div>

            <div class="flex flex-wrap mx-auto p-2">
              <label class="place-items-start pr-1 w-full" for="description">Description</label>
              <textarea rows="5" class="block w-full mx-auto" type="text" name="description" id="description" disabled>{{ $association->description }}</textarea>
            </div>
          </fieldset>

          <button id="validateBtn" class="hidden md:w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Valider les modifications</button>

        </form>
      </section>
      <section class="flex flex-wrap justify-center">
        <form class="flex flex-col flex-wrap content-center justify-around text-texte" action="/association/profil/delete" onsubmit="return confirm('Voulez-vous vraiment supprimer votre profil ? Cette action est irréversible !')">
        @csrf
          <button class="w-full md:w-[60%] mx-auto my-3 py-2 px-4 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Supprimer mon profil</button>
          <p class="text-center">ATTENTION ! Cette suppression est définitive !</p>
        </form>
      </section>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/editShelterInputs.js') }}" async></script>
@endpush
