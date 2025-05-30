@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">

  <div class="md:my-3 flex flex-wrap font-body w-full bg-zoning rounded-lg shadow justify-around">
    <form class="text-texte justify-around" method="POST">
      @csrf
      <div id="fullSearch" class="mx-2 col-span-3 items-center flex flex-wrap justify-around">
        <h2 class="font-grands text-2xl w-full my-2 text-center">Rechercher un animal</h2>
        <label for="espece-dropdown-small">Par espèce</label>
        <select tabindex=0 class="col-span-3 text-xs block w-[50%] bg-fond" id="espece-dropdown-small" name="_especeDropdownSmall">
          <option value="" disabled selected hidden>--Choisissez une espèce--</option>
          @foreach ($especes as $espece)
            <option name="espece" value="{{ $espece->id }}">{{ $espece->nom }}</option>
          @endforeach
        </select>
          <input tabindex="0" id="deploy" class="w-[20%] col-span-1 my-1 py-2 px-2 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="button" value="Filtres">
          <input tabindex="0" class="w-1/3 col-span-1 mx-auto my-3 py-2 px-2 bg-accents1-light text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit" value="Rechercher">
      </div>
      <div id="searchCriterias" class="hidden grid-cols-3 gap-1 mx-auto my-3 text-texte">
        <h3 class="col-span-3 font-grands text-3xl text-center my-2">Rechercher un animal</h3>

        <div class="col-span-1 mx-auto">
          <h4>Caractéristiques</h4>

          <div class="my-2">
            <label for="espece-dropdown-full">Espèce</label>
            <select tabindex=0 class="text-xs block bg-fond" id="espece-dropdown-full" name="_especeDropdownFull">
              <option value="" disabled selected hidden>--Choisissez une espèce--</option>
              @foreach ($especes as $espece)
                <option name="espece" value="{{ $espece->id }}">{{ $espece->nom }}</option>
              @endforeach
            </select>
          </div>

          <div class="my-2">
            <fieldset id="sexe">
              <legend>Sexe</legend>
              <label><input type="radio" name="_sexe" value="Mâle" class="mx-1">Mâle</label>
              <label><input type="radio" name="_sexe" value="Femelle" class="mx-1">Femelle</label>
              <label><input type="radio" name="_sexe" value="Inconnu" class="mx-1">Inconnu</label>
            </fieldset>
          </div>

          <div class="my-2">
            <p>Age :</p>
            <label class=# for="age-min">De&nbsp;</label>
            <input class="bg-fond" id="age-min" name="_minAge" type="number" tabindex=0 min="0" max="3999">
            <label class=# for="age-max">&nbsp;à&nbsp;</label>
            <input class="bg-fond" id="age-max" name="_maxAge" type="number" tabindex=0 min="1" max="4000">
            <label>&nbsp;ans.</label>
          </div>
        </div>

        <div class="col-span-1">
          <p>Exclure si :</p>
          @foreach ($tags as $tag)
            <div>
              <label class=# for="{{ $tag->nom }}">{{ $tag->nom }}</label>
              <input class=# type="checkbox" name="_tags[]" id="{{ $tag->nom }}" value="{{ $tag->nom }}"/>
            </div>
          @endforeach
        </div>

        <div class="col-span-1">
          <div class="my-2">
            <label for="dpt-select">Département</label>
            <select tabindex=0 class="text-xs block bg-fond" id="dpt-select" name="_dptSelect">
            @include('partials.dptSelect')
            </select>
          </div>
        </div>

        <input tabindex="0" class="col-span-3 w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"  type="submit" value="Rechercher">
      </div>
    </form>
  </div>

  @if (empty($animals))
    <h3 class="font-grands text-2xl w-full my-2 text-center">Aucun animal ne correspond à votre recherche</h3>
  @endif

    <div class="grid grid-flow-row-dense grid-cols-3 gap-3 m-3">
      @foreach ($animals as $animal)
        <div class="bg-zoning rounded-lg shadow md:flex-col">

          <div class="relative md:w-full flex justify-center items-center">
            @if (empty($animal->images_animal))
              <img class="font-body rounded-lg" src="/images/animal_empty.webp" alt="Photo à venir">
            @else
              <img class="font-body rounded-lg"
              src="{{ $animal->images_animal[0]->url}}" alt="Photo de" . {{ $animal->nom }}>
            @endif
          </div>

          <div class="flex-auto text-center">
            <div class="flex flex-wrap">
              <h3 class="flex-auto text-xl md:text-3xl font-grands">{{ $animal->nom }}</h3>
              <h4 class="flex-none w-full mt-2 text-xs md:text-xl font-medium text-gray-500">{{ $animal->espece->nom }}</h4>
              <hr>
              <p class="flex-none w-full mt-2 text-xs md:text-xl font-medium text-gray-500">Age : {{ $animal->age }}</p>
              <p class="flex-none w-full mt-2 text-xs md:text-xl font-medium text-gray-500">Localisation : {{ $animal->refuge->code_postal }}</p>
            </div>
            <div class="flex text-sm font-medium justify-center">
              <a class="my-2 bg-accents1-light text-fond w-[90%] transition ease-in duration-200 text-center text-xs md:text-2xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="animaux/{{ $animal->id }}">Découvrir</a>
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
