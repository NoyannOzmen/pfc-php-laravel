@extends('layouts.app')
@section('content')
<main class="flex flex-wrap flex-col md:flex-row justify-self-stretch flex-1 w-full place-content-evenly 2xl:w-1/2 2xl:self-center">
    <section class="flex flex-col m-4 flex-1 max-[767px]:mx-4 md:ml-6 place-content-evenly">
		<h2 class="font-grands text-2xl md:text-3xl text-center w-full my-6">{{ $animal->nom }}</h2>

		<div class="font-body mx-auto w-[80%] bg-zoning rounded-lg shadow dark:bg-gray-800 my-4">
            @if (empty($animal->images_animal))
                <img class="mx-auto my-2" src="/images/animal_empty.webp" alt="Photo à venir">
            @else
                <img class="mx-auto my-2" src="{{ $animal->images_animal[0]->url}}" alt="Photo de" . {{ $animal->nom }}>
            @endif
		</div>

		<article class="font-body mx-auto w-[80%] bg-zoning rounded-lg shadow dark:bg-gray-800 my-4">
			<div class="text-center w-full py-2">
				<h3 class="font-grands text-3xl text-center my-2 w-full">A propos de {{ $animal->nom }}</h3>
			</div>

 			@if ($animal->tags)
			<div class="text-center w-full py-2">
                @foreach ($animal->tags as $tag)
                <button class="group p-1 rounded-lg bg-accents1-dark text-fond text-center">
                    {{ $tag->nom }}
                    <span class="group-hover:block hidden z-10 bg-accents2-dark text-fond absolute px-2 py-2 text-xs rounded-b-xl rounded-tr-xl">
                        {{ $tag->description }}
                    </span>
                </button>
                @endforeach
			</div>
			@endif

			<div class="text-center w-full py-2">
				<p class="font-body text-texte">Nom : {{ $animal->nom }}</p>
				<p class="font-body text-texte">Age : {{ $animal->age }}&nbsp;ans</p>
				<p class="font-body text-texte">Sexe : {{ $animal->sexe }}</p>
			</div>
			<div class="text-center w-full py-2">
				<p class="font-body text-texte">Espèce : {{ $animal->espece->nom }}</p>
				@if ($animal->race)
				<p class="font-body text-texte">Race : {{ $animal->race }}</p>
				@endif
				<p class="font-body text-texte">Couleur : {{ $animal->couleur }}</p>
			</div>
			<div class="text-center w-full py-2">
				<p class="font-body text-texte">Statut : {{ $animal->statut }}</p>
			</div>

			<div class="text-center w-full py-2">
				<p class="font-body text-texte">Son petit truc en plus :<br>{{ $animal->description }}</p>
			</div>
		</article>

        @auth
            @if (Auth::user()->accueillant)
            <div class="text-center w-full py-2">

                @if(session('error'))
                <div class="alert alert-danger">
                    <p class="flash-notice font-grands font-base text-accents1 text-center">{{ session('error') }}</p>
                </div>
                @endif

                <form method="POST">
                @csrf
                    <button type="submit" class="mx-auto my-3 py-2 px-6 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">Faire une demande</button>
                </form>
            </div>
            @endif
        @endauth
	</section>

    <section class="flex flex-col md:my-8 flex-none  md:max-w-[50%] max-[767px]:mx-4 md:mr-6 md:mt-32 py-6">
		<article class="font-body mx-auto w-full bg-zoning rounded-lg shadow dark:bg-gray-800 my-4">
			<h3 class="font-grands text-3xl text-center my-2 pt-5 w-full">{{ $animal->nom }}<br>vous attend chez<br>{{ $animal->refuge->nom }}</h3>


			<div class="font-body mx-auto w-[80%] rounded-lg my-4">
                @if (empty($animal->refuge->images_association))
                    <img class="mx-auto" src="{{ $animal->refuge->images_association[0]->url }}" alt="Logo de" . {{ $animal->refuge->nom }}>
                @else
                    <img src="/images/shelter_empty.webp" alt="Logo de" . {{ $animal->refuge->nom }} . "bientôt visible">
                @endif
			</div>

			<div class="text-center w-full py-2">
				<p class="font-body text-texte">Adresse : {{ $animal->refuge->rue }},<br>{{ $animal->refuge->code_postal }},&nbsp;{{ $animal->refuge->commune}},&nbsp;{{ $animal->refuge->pays }}</p>
				<p class="font-body text-texte">Téléphone : {{ $animal->refuge->telephone }}</p>
 				@if ($animal->refuge->site)  <p class="font-body text-texte">E-mail : {{ $animal->refuge->site }}</p> @endif
				@if ($animal->refuge->description) <p class="font-body text-texte">{{ $animal->refuge->description }}</p> @endif
			</div>

			<div class="text-center w-full py-2">
				<a class="w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" href="/associations/{{ $animal->refuge->id }}">En savoir plus</a>
			</div>
		</article>
	</section>

	<section class="p-4 py-6 block">
		<h2 class="font-grands text-3xl text-center my-2">Eux aussi vous attendent chez {{ $animal->refuge->nom }} !</h2>

		<section id="animal-carousel" class="md:flex md:flex-row relative mx-auto h-auto w-[90%] bg-zoning rounded-lg shadow dark:bg-gray-800">

			<button
			class="absolute top-0 start-0 z-1 flex items-center justify-center h-full pl-2 cursor-pointer group focus:outline-none size-10 opacity-75"
			type="button" id="previous" aria-label="Précédent" tabindex="0"><img src="/icons/left.svg" alt=""></button>

			<div class="h-auto w-auto flex rounded-lg p-4 md:my-6 md:gap-4 md:px-8">
				@foreach ($animal->refuge->pensionnaires as $p)
					<div class="hidden carousel-img" >
						<div class="flex bg-fond rounded-lg shadow dark:bg-gray-800 flex-row md:flex-col mx-auto my-2 w-[75%] p-4">
							<div class="w-full md:w-full flex justify-center items-center">
								@if (empty($p->images_animal))
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="/images/animal_empty.webp"
									alt="Photo à venir">
							 	@else
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="{{ $p->images_animal[0]->url}}" alt="Photo de" . {{ $p->nom}}>
								@endif
							</div>
							<div class="flex-auto text-center">
								<div class="flex flex-wrap my-2">
									<h3 class="flex-auto text-xl font-grands font-semibold">
										{{ $p->nom }}
									</h3>
									<h4 class="flex-none w-full mt-2 text-sm font-medium text-gray-500">
										{{ $p->espece->nom }}
									</h4>
									<hr>
									<p class="flex-none w-full mt-2 text-sm font-medium text-gray-500">Age : {{ $p->age }}
									</p>
									<p class="flex-none w-full mt-2 text-sm font-medium text-gray-500">Localisation : {{ $p->refuge->code_postal }}
									</p>
								</div>
								<div class="flex mb-4 text-sm font-medium">
									<a class="py-2 px-4 bg-accents1-light text-fond w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"
									href="/animaux/{{ $p->id }}">Découvrir</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>

			<button
			class="absolute top-0 end-0 z-1 flex items-center justify-center h-full pr-2 cursor-pointer group focus:outline-none size-10 opacity-75"
			type="button" id="next" aria-label="Suivant" tabindex="0"><img src="/icons/right.svg" alt=""></button>
		</section>
	</section>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/carousel.js') }}" async></script>
@endpush
