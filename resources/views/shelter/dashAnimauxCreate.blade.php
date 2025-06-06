@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
	<h2 class="font-grands text-3xl text-center my-2 pt-5">Mon espace association</h2>
  <div class="flex flex-col content-center justify-center mx-auto mb-4 w-[80%]">

    <nav class="flex flex-wrap justify-center md:justify-start">
      <ul class="flex flex-wrap-reverse gap-x-2 mx-3 justify-center font-semibold md:justify-start md:ml-10 text-xl">
        <li><a href="/association/profil" tabindex="0"><button id="dashbtn-1" class="dashbtn" tabindex="-1">Profil</button></a></li>
        <li><a href="/association/profil/demandes" tabindex="0"><button id="dashbtn-2" class="dashbtn" tabindex="-1">Demandes</button></a></li>
        <li><a href="/association/profil/animaux" tabindex="0"><button id="dashbtn-3" class="dashbtn dashbtn-active" tabindex="-1">Animaux</button></a></li>
      </ul>
      <div class="mx-2 grow w-[90%] h-2 bg-accents1-dark rounded-t-lg"></div>
    </nav>

    <div class="flex flex-col bg-zoning rounded-lg">
      <nav class="rounded-lg">
        <ul class="rounded-t-lg flex bg-accents2 justify-stretch font-semibold text-fond text-sm md:justify-start md:pl-8">
          <li class="rounded-tl-lg block grow text-center pl-2 border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 md:rounded-none md:border-l-2 md:border-l-zoning bor"><a href="/association/profil/animaux">Nos animaux</a></li>
          <li class="block grow text-center border-r-solid border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 "><a href="/association/profil/animaux/suivi">Suivi accueils</a></li>
          <li class="dashsubbtn-active block grow text-center pr-2 py-2 rounded-tr-lg hover:underline md:grow-0 md:px-4 md:rounded-none md:border-r-solid md:border-r-2 md:border-r-zoning"><a href="/association/profil/animaux/nouveau-profil">Créer un profil</a></li>
        </ul>
      </nav>

      <section class="flex flex-col justify-center content-center">
        <h3 class="hidden md:inline font-grands text-3xl text-center my-2 pt-5 w-full">Créer un profil animal</h3>

        <form class="grid grid-cols-1 my-6 mx-6 justify-center lg:flex-none lg:mx-2 lg:grid lg:grid-cols-3 lg:px-2 xl:grid-cols-3 xl:p-10" name="create_animal" method="POST">
        @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="flash-notice font-grands font-base text-accents1 text-center">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

          <input type="hidden" name="create_animal" value="create_animal">
          <fieldset class="flex flex-wrap justify-center content-start gap-x-4">

            <div class="mb-2 w-[90%]">
              <label for="nom_animal" class="block font-grands w-full font-bold text-base ">Nom</label>
              <input class="w-full rounded-md h-8 px-2 py-1 text-texte bg-fond " type="text" name="_nom_animal" id="nom_animal" required>
            </div>

            <div class="mb-2 w-[90%]">
              <label for="sexe_animal" class="block w-full font-grands font-bold text-base ">Sexe</label>
              <select name="_sexe_animal" id="sexe_animal" class="custom-select w-full rounded-md h-8 px-2 py-1 text-texte bg-fond ">
                <option value="Inconnu">Inconnu</option>
                <option value="Mâle">Mâle</option>
                <option value="Femelle">Femelle</option>
              </select>
            </div>

            <div class="mb-2 w-[90%]">
              <label for="age_animal" class="block w-full font-grands font-bold text-base ">Age</label>
              <input class="w-full rounded-md h-8 px-2 py-1 text-texte bg-fond " type="number" name="_age_animal" id="age_animal" required>
            </div>
          </fieldset>

          <hr class="border-t-accents2 w-1/3 border-t-2 border-solid justify-self-center my-4 md:hidden">

          <fieldset class="flex flex-wrap justify-center content-start gap-x-4">

            <div class="mb-2 w-[90%] md:shrink md:grow-0 self-start">
              <label for="espece_animal" class="block w-full font-grands font-bold text-base ">Espèce</label>
              <select name="_espece_animal" id="espece_animal" class="custom-select w-full rounded-md h-8 px-2 py-1 text-texte bg-fond ">
                <option value="">Choisissez</option>
                  @foreach ($especes as $espece)
                    <option value="{{ $espece->id }}">{{ $espece->nom }}</option>
                  @endforeach
              </select>
            </div>

            <div class="mb-2 w-[90%]">
              <label for="race_animal" class="block w-full font-grands font-bold text-base ">Race</label>
              <input class="w-full rounded-md h-8 px-2 py-1 text-texte bg-fond " type="text" name="_race_animal" id="race_animal">
            </div>
            <div class="mb-2 w-[90%]">
              <label for="couleur_animal" class="block w-full font-grands font-bold text-base ">Couleur</label>
              <input class="w-full rounded-md h-8 px-2 py-1 text-texte bg-fond " type="text" name="_couleur_animal" id="couleur_animal" required>
            </div>
          </fieldset>

          <hr class="border-t-accents2 w-1/3 border-t-2 border-solid justify-self-center my-4 md:hidden">

          <fieldset class="flex flex-wrap justify-center gap-x-4">

            <div class="mb-2 grow ">
              <label for="description_animal" class="block font-grands font-bold text-base w-full">Description</label>
              <textarea class="w-full rounded-md px-2 py-1 text-texte bg-fond " name="_description_animal" id="description_animal" rows="3" required></textarea>
            </div>

            <div class="mb-2 w-full">
              <p for="couleur-animal" class="block font-grands font-bold text-base mb-4 shrink">Tags</p>

              <fieldset name="_tags-animal" id="tags-animal" class="grid grid-cols-1 md:grid-cols-2 gap-2 w-full px-2 py-1">

                @foreach ($tags as $tag)
                  <div class="flex gap-x-1.5 w-full">
                    <input type="checkbox" id="tag_{{ $tag->id }}" name="_tag[]" value="{{ $tag->id }}" class="leading-3 size-6"/>
                    <label for="_tag" class="block font-grands text-xs leading-3">{{ $tag->nom }}</label>
                  </div>
                @endforeach

              </fieldset>

              <div class="flex justify-center">
                <button id="create-tag" type="button" class="self-center hover:bg-accents1-dark rounded-full hover:underline bg-accents1-light text-center font-grands text-fond font-semibold text-base py-0.5 px-4">Créer un tag</button>
              </div>

              @if(session('error'))
                <div class="alert alert-danger flex justify-center">
                    <p class="flash-notice font-grands font-base text-accents1 text-center">{{ session('error') }}</p>
                </div>
              @endif
            </div>

          </fieldset>

          <hr class="border-t-accents2 w-1/3 border-t-2 border-solid justify-self-center my-4 md:hidden">

          <fieldset class="flex flex-wrap justify-center w-full lg:col-start-2 lg:columns-2">
            <div class="">
              <input type="submit" value="Créer le profil" class="hover:bg-accents1-dark rounded-full hover:underline bg-accents1 text-center font-grands text-fond font-semibold text-xl py-2 px-4">
            </div>
          </fieldset>

        </form>
      </section>
    </div>
  </div>
</main>

<div id="create-tags-modal" class="hidden justify-center content-center fixed bg-texte/20 inset-0">

  <div class="self-center w-1/3 mx-auto bg-zoning p-6 rounded-lg">
    <div class="flex justify-between">
      <h3 class="font-grands text-lg font-extrabold mb-4">Ajouter un tag</h3>
      <span class="cancel material-symbols-outlined text-texte cursor-pointer">
        close
      </span>
    </div>
    <form id="create-tags-form" name="create_tag" method="POST">
    @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="flash-notice font-grands font-base text-accents1 text-center">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
      <input type="hidden" name="create_tag" value="create_tag">
      <fieldset class="mb-2">
        <label for="name_tag" class="block text-texte font-grands font-bold text-base">Nom du Tag</label>
        <input class="w-56 rounded-md h-8 px-2 py-1 text-texte bg-fond" type="text" name="_name_tag" id="name_tag" required>
      </fieldset>

      <fieldset class="mb-4 ">
        <label for="desc_tag" class="block text-texte font-grands font-bold text-base">Description</label>
        <textarea class="w-56 rounded-md px-2 py-1 text-texte bg-fond" name="_desc_tag" id="desc_tag" rows="3" required></textarea>
      </fieldset>

      <fieldset>
        <input class="cursor-pointer hover:bg-accents1-dark rounded-full hover:underline bg-accents1 text-center font-grands text-fond font-semibold text-base py-1 px-4" type="submit" value="Valider">
        <button class="hover:bg-accents2-dark rounded-full hover:underline bg-accents2-dark text-center font-grands text-fond font-semibold text-base py-1 px-4 cancel">Annuler</button>
      </fieldset>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardAssoCreateTag.js') }}"></script>
@endpush
