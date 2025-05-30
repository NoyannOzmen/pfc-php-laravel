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
          <li class="block grow text-center pl-2 border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4 md:rounded-none md:border-l-2 md:border-l-zoning bor"><a href="/association/profil/">Mes informations</a></li>
          <li class="dashsubbtn-active rounded-tl-lg block grow text-center border-r-solid border-r-2 border-r-zoning py-2 hover:underline md:grow-0 md:px-4"><a href="/association/profil/logo">Ajouter une image</a></li>
        </ul>
      </nav>

      <section class="flex flex-col flex-wrap justify-center" id="dashboard-container">
        <h3 class="font-grands text-3xl text-center my-2 pt-5 w-full">Ajouter une image</h3>

        <form class="self-center" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="flex flex-col">
            <label for="file" class="text-center">Importer une image</label>
            <input id="file" type="file" name="file" required/>
          </div>
          @error('file')
            <div class="font-grands font-base text-accents1 text-center">{{ $message }}</div>
          @enderror
          <div class="flex justify-center">
            <input type="submit" value="Importer" class="my-3 py-2 px-4 mx-auto bg-accents2-dark text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"/>
          </div>
        </form>
      </section>

        <div class="flex flex-col justify-center">
          <h3 class="font-body text-2xl text-center">Votre Logo actuel</h3>
          @if (count($association->images_association) == 0)
            <img class="w-[40%] mx-auto rounded-lg" src="/images/shelter_empty.webp" alt="">
          @else
            <img class="w-[40%] mx-auto rounded-lg" src="{{ $association->images_association[0]->url }}" alt="">
          @endif
        </div>
    </div>
  </div>
</main>
@endsection
