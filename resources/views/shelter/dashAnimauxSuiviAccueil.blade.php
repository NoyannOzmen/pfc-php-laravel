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
          <li class=" rounded-tl-lg block grow text-center pl-2 border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 md:rounded-none md:border-l-2 md:border-l-zoning bor"><a href="/association/profil/animaux">Nos animaux</a></li>
          <li class="dashsubbtn-active block grow text-center border-r-solid border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 "><a href="/association/profil/animaux/suivi">Suivi accueils</a></li>
          <li class="block grow text-center pr-2 py-2 rounded-tr-lg hover:underline md:grow-0 md:px-4 md:rounded-none md:border-r-solid md:border-r-2 md:border-r-zoning"><a href="/association/profil/animaux/nouveau-profil">Créer un profil</a></li>
        </ul>
      </nav>

      <section class="flex flex-wrap justify-center" id="dashboard-container">
        <h3 class="hidden md:inline font-grands text-3xl text-center my-2 pt-5 w-full">Suivi des animaux accueillis</h3>

        <div class="w-full mx-4 my-6">
          <table class="text-left w-full">

            <tr class="border-none bg-zoning text-sm font-grands">
              <th>Nom Animal</th>
              <th>Famille d'Accueil</th>
            </tr>

            @foreach ($animals as $animal)
              <tr tabindex="0" class="view  text-fond text-sm bg-accents2 font-grands font-semibold p-3 border-accents2-dark border-solid border-1 hover:bg-accents2-dark">
                <td class="px-2 pt-2  border-accents2-dark border-solid border-1">{{ $animal->nom }}</td>
                <td class="px-2 pt-2  border-accents2-dark border-solid border-1">{{ $animal->famille->nom }}</td>
              </tr>

              <tr class="fold hidden mb-3 bg-fond rounded-b-lg ">
                <td class="w-full rounded-xl" colspan="2">
                  <div class="flex flex-wrap p-2 justify-center md:flex-nowrap" >

                    <div class="w-full md:w-1/2">
                      <h3 class="font-body font-bold">Animal</h3>

                      <div class="flex p-6 pb-4">
                        <div class="flex flex-col gap-2">
                          @if (empty($animal->images_animal))
                            <img class="w-28 rounded-lg" src="/images/animal_empty.webp" alt="Photo à venir">
                          @else
                            <img class="w-28 rounded-lg" src="{{ $animal->images_animal[0]->url }}" alt="Photo de" . {{ $animal->nom }}>
                          @endif
                          <a class="rounded-full block bg-accents1 text-fond w-16 text-center text-xs font-semibold py-1 hover:underline" href="/association/profil/animaux/{{ $animal->id }}">Détails</a>
                        </div>

                        <div class="pl-4">
                          <p class="text-base italic leading-3">Nom</p>
                          <p class="text-base font-semibold">{{ $animal->nom }}</p>
                        </div>
                      </div>

                      <div class="grid grid-cols-2 px-6 gap-y-2">
                        <div>
                          <p class="text-sm italic leading-3">Age</p>
                          <p class="text-base font-semibold">{{ $animal->age }}&nbsp;ans</p>
                        </div>

                        <div>
                          <p class="text-sm italic leading-3">Sexe</p>
                          <p class="text-base font-semibold">{{ $animal->sexe }}</p>
                        </div>

                        <div class="">
                          <p class="text-sm italic leading-3">Espèce</p>
                          <p class="text-base font-semibold">{{ $animal->espece->nom }}</p>
                        </div>

                        @if ($animal->race)
                          <div>
                            <p class="text-sm italic leading-3">Race</p>
                            <p class="text-base font-semibold">{{ $animal->race }}</p>
                          </div>
                        @endif
                      </div>
                      <div class="flex flex-wrap mt-4 px-6 gap-1">
                      @foreach ($animal->tags as $tag)
                          <p class="group rounded-full block bg-accents1 text-fond text-center text-xs font-semibold py-1 px-2">
                                {{ tag->nom }}
                                <span class="group-hover:block hidden z-10 bg-accents2-dark text-fond absolute px-2 py-2 text-xs rounded-b-xl rounded-tr-xl">
                                  {{ tag->description }}
                                </span>
                              </p>
                      @endforeach
                      </div>
                    </div>

                    <hr class="border-t-accents2 w-2/4 border-t-2 border-solid justify-self-center my-4 md:hidden">

                    <div class="w-full md:w-1/2">
                      <h3 class="font-body font-bold mb-4">Famille</h3>

                      <div class="px-6 mb-3 md:grid-cols-2 md:grid">
                        <div class="mb-2 mt-2">
                          <p class="text-sm italic leading-3">Nom</p>
                          <p class="text-base font-semibold">{{ $animal->famille->nom }}</p>
                        </div>
                        <div class="mb-2">
                          <p class="text-sm italic leading-3">Téléphone</p>
                          <p class="text-base font-semibold">{{ $animal->famille->telephone }}</p>
                        </div>
                        <div class="mb-2">
                          <p class="text-sm italic leading-4">Adresse</p>
                          <p class="text-base font-semibold leading-3">{{ $animal->famille->rue }}</p>
                          <p class="text-base font-semibold ">{{ $animal->famille->code_postal }}&nbsp;{{ $animal->famille->commune  }}</p>
                        </div>
                        <div class="mb-2">
                          <p class="text-sm italic leading-3">Pays</p>
                          <p class="text-base font-semibold">{{ $animal->famille->pays }}</p>
                        </div>
                        <div>
                          <p class="text-sm italic leading-3">Hébergement</p>
                          <p class="text-base font-semibold">{{ $animal->famille->hebergement }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </section>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardAssoSuiviAccueil.js') }}"></script>
@endpush
