@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">

  <div class="md:my-3 flex flex-wrap font-body w-full bg-zoning rounded-lg shadow justify-around">
    <form class="text-texte justify-around" method="POST">
      @csrf
      <div id="fullSearch" class="mx-2 col-span-3 items-center flex flex-wrap justify-around">
        <h2 class="font-grands text-2xl w-full my-2 text-center">Rechercher une association</h2>
        <label for="dpt-select-small">Par département</label>
        <select tabindex=0 class="col-span-3 text-xs block w-[50%] bg-fond" id="dpt-select-small" name="_dptSelectSmall">
        @include ('partials.dptSelect')
        </select>
        <input tabindex="0" id="deploy" class="w-[20%] col-span-1 my-1 py-2 px-2 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="button" value="Filtres">
        <input tabindex="0" class="w-1/3 col-span-1 mx-auto my-3 py-2 px-2 bg-accents1-light text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit" value="Rechercher">
      </div>

      <div id="searchCriterias" class="hidden grid-cols-3 gap-1 mx-auto my-3 text-texte">
        <h3 class="col-span-3 font-grands text-3xl text-center my-2">Rechercher une association</h3>
        <div class="col-span-1 mx-auto">
          <fieldset class="mx-auto p-2 my-2">
            <label class=# for="shelter-nom">Nom du refuge</label>
            <input class="text-xs block bg-fond" type="text" id="shelter-nom" name="_shelterNom" placeholder="--Entrez un nom--">
          </fieldset>
        </div>

        <div class="col-span-1">
          <fieldset class="mx-auto p-2 my-2">
            <legend>Animaux</legend>
            @foreach ($especes as $espece)
              <div>
                <label for="_espece[]">{{ $espece->nom }}</label>
                <input type="checkbox" name="_espece[]" id="{{ $espece->nom}}" value="{{ $espece->id }}"/>
              </div>
            @endforeach
          </fieldset>
        </div>

        <div class="col-span-1">
          <fieldset class="mx-auto p-2 my-2">
              <label for="dpt-select-full">Département</label>
              <select tabindex=0 class="text-xs block bg-fond" id="dpt-select-full" name="_dptSelectFull">
                @include ('partials.dptSelect')
              </select>
          </fieldset>
        </div>

        <input tabindex="0" class="col-span-3 w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"  type="submit" value="Rechercher" />

      </div>
    </form>
  </div>

  <div class="flex flex-wrap content-center justify-around my-8">
    <section class="mx-auto w-[80%]">
      <h2 class="font-grands text-3xl text-center my-2">Nos partenaires</h2>
      <p class="mx-auto text-l font-body text-center">Pet Foster Connect a l'honneur de travailler main dans la main avec des refuges et associations de protection animale sur tout le territoire Français.<br>Retrouvez-les ci-dessous.
        <br><br>Vous pouvez également effectuer une recherche pour trouver les plus proches de chez vous !
      </p>
    </section>
  </div>

  @if (empty($associations))
    <h3 class="font-grands text-2xl w-full my-2 text-center">Aucun refuge ne correspond à votre recherche</h3>
  @endif

      <div class="grid grid-cols-3 gap-3 m-3">
        @foreach ($associations as $association)
          <div class="bg-zoning rounded-lg shadow flex flex-col">

            <div class="relative md:w-full flex justify-center items-center">
              @if (empty($association->images_association))
              <img class="font-body rounded-lg" src="/images/shelter_empty.webp" alt="Logo de" . {{ $association->nom }} . "bientôt visible">
              @else
              <img class="font-body rounded-lg" src="{{ $association->images_association[0]->url }}" class="rounded-lg"  alt="Logo de" . {{ $association->nom }}>
              @endif
            </div>

            <div class="flex text-center flex-col">
              <div class="flex flex-wrap">
                <h3 class="flex-auto text-xl md:text-3xl font-grands">{{ $association->nom }}</h3>
                <hr>
                <p class="flex-none w-full mt-2 text-xs md:text-xl font-medium text-gray-500">Localisation : {{ $association->code_postal }}&nbsp;{{ $association->commune }}</p>
              </div>
              <div class="flex text-sm font-medium justify-center items-end">
                <a class="my-2 bg-accents1-light text-fond w-[90%] transition ease-in duration-200 text-center text-xs md:text-2xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/associations/{{ $association->id  }}">En savoir plus</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

</main>
@endsection

@push('scripts')
<script src="{{ asset('js/deploySearch.js') }}" async></script>
@endpush
