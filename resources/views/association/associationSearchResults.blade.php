@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">

  <div class="md:my-3 flex flex-wrap font-body w-full bg-zoning rounded-lg shadows justify-around">
    @if (count($searchedShelters) > 0)
      <h3 class="font-grands text-2xl w-full my-2 text-center">Résultats de votre recherche</h3>
    @else
      <h3 class="font-grands text-2xl w-full my-2 text-center">Aucun refuge ne correspond à votre recherche</h3>
    @endif
    <a tabindex="0" class="w-[30%] col-span-1 my-1 py-2 px-2 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-xs font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/associations">Revenir à la recherche</a>
  </div>

  <div class="grid grid-cols-3 gap-3 m-3">
    @foreach ($searchedShelters as $association)
      <div class="bg-zoning rounded-lg shadows flex flex-col">

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
            <a class="my-2 bg-accents1-light text-fond w-[90%] transition ease-in duration-200 text-center text-xs md:text-2xl font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/associations/{{ $association->id }}">En savoir plus</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</main>
@endsection
