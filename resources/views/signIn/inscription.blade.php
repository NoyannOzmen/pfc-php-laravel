@extends('layouts.app')
@section('content')
  <main class="justify-self-stretch flex-1">
    <h2 class="font-grands text-3xl text-center my-2 pt-10">Inscription</h2>

    <section class="pt-10">
      <div class="font-body mx-auto w-[80%] md:w-[60%] bg-zoning rounded-lg shadow dark:bg-gray-800">

        <div class="flex flex-col flex-wrap justify-around text-texte">
          <p class="font-grands text-xl text-center my-2 pt-10">Je suis...</p>
          <div class="mx-auto p-2 w-[60%]">
          <a href="/famille/inscription"><button class="w-full mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="button">Une famille d'accueil</button></a>
          </div>

          <div class="mx-auto p-2 w-[60%]">
          <a href="/association/inscription"><button class="w-full mx-auto my-3 py-2 px-4 bg-accents2-dark text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="button">Un refuge</button></a>
          </div>

          <a href='/rgpd' class="font-body text-texte text-center text-m pb-4">Consulter nos Conditions d'Utilisation</a>
        </div>
      </div>
    </section>
  </main>
@endsection
