@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">

  <div class="md:my-3 flex flex-wrap font-body w-full bg-zoning rounded-lg shadow justify-around">
    @if (count($searchedAnimals) > 0)
      <h3 class="font-grands text-2xl w-full my-2 text-center">Résultats de votre recherche</h3>
    @else
        <h3 class="font-grands text-2xl w-full my-2 text-center">Aucun animal ne correspond à votre recherche</h3>
    @endif
    <a tabindex="0" class="w-[30%] col-span-1 my-1 py-2 px-2 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/animaux">Revenir à la recherche</a>
  </div>

  <div class="grid grid-flow-row-dense grid-cols-3 gap-3 m-3">

    @foreach ($searchedAnimals as $animal)
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
            <a class="my-2 bg-accents1-light text-fond w-[90%] transition ease-in duration-200 text-center text-xs md:text-2xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/animaux/{{ $animal->id }}">Découvrir</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

</main>
@endsection
