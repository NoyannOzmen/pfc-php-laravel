@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
  <h2 class="font-grands text-3xl text-center my-2 py-6">Bienvenue sur votre espace personnel</h2>
  <div class="flex flex-col content-center justify-center mx-auto mb-4 w-[80%]">

    <nav class="flex flex-wrap justify-center md:justify-start">
      <ul class="flex flex-wrap-reverse gap-x-2 mx-3 justify-center font-semibold md:justify-start md:ml-10 text-xl">
        <li><a href="/famille/profil" tabindex="0"><button id="dashbtn-1" class="dashbtn" tabindex="-1">Profil</button></a></li>
        <li><a href="/famille/profil/demandes" tabindex="0"><button id="dashbtn-2" class="dashbtn dashbtn-active" tabindex="-1">Demandes</button></a></li>
      </ul>
      <div class="mx-2 grow w-[90%] h-2 bg-accents1-dark rounded-t-lg"></div>
    </nav>

    <div class="font-body bg-zoning rounded-lg shadow mb-4">

      <section class="flex flex-wrap justify-center" id="dashboard-container">

        <h3 class="font-grands text-3xl text-center my-2 pt-5 w-full">Gestion des demandes d'accueil</h3>

        <div class="container w-[80%]">

          <div class="row w-full text-center my-6">
            <div class="col w-full text-center my-6">
                @if (empty($requests))
                    <h4 class="w-full text-center font-grands text-2xl my-4">Pas de demandes d'accueil en attente</h4>
                @else
                    <h4 class="w-full text-center font-grands text-2xl my-4">Demandes en cours</h4>

                    <table class="table text-center w-full">
                        <tr class="border-none bg-zoning text-sm font-grands">
                            <td colspan="3" scope="colgroup">Nom Animal</td>
                            <td colspan="3" scope="colgroup">Demande</td>
                        </tr>
                    @foreach ($requests as $request)
                        <tr tabindex="0" class="view text-fond text-sm bg-accents2 font-grands font-semibold p-3 border-accents2-dark border-solid border-1 hover:bg-accents2-dark">
                            <td colspan="3" scope="colgroup" class="px-2 pt-2  border-accents2-dark border-solid border-1">{{ $request->animal_accueillable->nom }}</td>
                            <td colspan="3" scope="colgroup" class="px-2 pt-2  border-accents2-dark border-solid border-1">Demande</td>
                        </tr>
                        <tr class="fold mb-3 bg-fond rounded-b-lg hidden">
                            <tr class="fold text-fond text-sm bg-accents2-light font-grands font-semibold p-3 border-accents2-dark border-solid border-1 hidden">
                                <td colspan="2" class="px-2 pt-2  border-accents2-light border-solid border-1">Refuge</td>
                                <td colspan="2" class="px-2 pt-2  border-accents2-light border-solid border-1">Date de demande</td>
                                <td colspan="2" class="px-2 pt-2  border-accents2-light border-solid border-1">Statut</td>
                            </tr>
                            <tr class="fold text-sm font-body font-semibold hidden bg bg-fond">
                                <td colspan="2">{{ $request->animal_accueillable->refuge->nom }}</td>
                                <td colspan="2">{{ $request->date_debut }}</td>
                                <td colspan="2">{{ $request->statut_demande }}</td>
                            </tr>
                        </tr>
                    @endforeach
                    </table>
                @endif
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboardSuiviDemande.js') }}"></script>
@endpush
