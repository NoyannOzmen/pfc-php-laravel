@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1 flex flex-col">
  <section class="flex flex-col h-[80%] bg-right bg-cover bg-unai place-content-center">
    <div class="flex flex-col rounded-2xl bg-texte/35 py-10 m-6 max-w-4xl">
      <h2 class="stroke-title font-grands px-12 text-5xl">Parce que chaque animal a besoin d'un toit...</h2>
      <p class="text-fond p-12 max-w-4xl text-base">Vous aimez les animaux et êtes soucieux de leur bien-être ?<br>Vous souhaitez venir en aide à un refuge proche de vous ?<br>Vous n'êtes pas encore sûrs de pouvoir adopter durablement un animal ?<br>Vous n'avez jamais eu d’animal mais aimeriez bien en avoir un ?</p>
      <div class="px-12">
        <a href="/devenir-famille-d-accueil" class="text-base rounded-full bg-accents1 hover:bg-accents1-light text-fond font-bold uppercase p-4">Devenez famille d'accueil</a>
      </div>
    </div>
  </section>

  <section class="p-4 block mx-auto">
    <h2 class="font-grands text-3xl text-center my-2">Ils vous attendent de patte ferme !</h2>
    <section id="animal-carousel"
		  class="md:flex md:flex-row relative mx-auto h-auto w-[90%] bg-zoning rounded-lg shadow dark:bg-gray-800">

			<button
			class="absolute top-0 start-0 z-1 flex items-center justify-center h-full pl-2 cursor-pointer group focus:outline-none size-10 opacity-75"
			type="button" id="previous" aria-label="Précédent" tabindex="0"><img src="/icons/left.svg" alt=""></button>

			<div class="flex -auto w-auto rounded-lg p-4 md:my-6 md:gap-4 md:px-8">
				@foreach ($animals as $animal)
					<div class="hidden carousel-img" >
						<div class="flex bg-fond rounded-lg shadow dark:bg-gray-800 flex-row md:flex-col mx-auto my-2 w-[75%] p-4">
							<div class="w-full md:w-full flex justify-center items-center">
								 @if (empty($animal->images_animal))
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="/images/animal_empty.webp"
									alt="Photo à venir">
							 	@else
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="{{ $animal->images_animal[0]->url}}" alt="Photo de" . {{ $animal->nom }}>
								@endif
							</div>
							<div class="flex-auto text-center">
								<div class="flex flex-wrap my-2">
									<h3 class="flex-auto text-xl font-grands font-semibold">
										{{ $animal->nom }}
									</h3>
									<h4 class="flex-none w-full mt-2 text-sm font-medium text-gray-500">
										{{ $animal->espece->nom }}
									</h4>
									<hr>
									<p class="flex-none w-full mt-2 text-sm font-medium text-gray-500">Age : {{ $animal->age }}
									</p>
									<p class="flex-none w-full mt-2 text-sm font-medium text-gray-500">Localisation : {{ $animal->refuge->code_postal }}
									</p>
								</div>
								<div class="flex mb-4 text-sm font-medium">
									<a class="py-2 px-4 bg-accents1-light text-fond w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"
									href="/animaux/{{ $animal->id }}">Découvrir</a>
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
