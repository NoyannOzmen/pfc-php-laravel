@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
  <section class="flex flex-col mx-auto mt-2">
    <h2 class="font-grands text-2xl md:text-3xl text-center w-full my-6">{{ $association->nom }}</h3>

    <div class="font-body mx-auto w-[80%] rounded-lg my-1 justify-center flex">
      @if (empty($association->images_association))
        <img src="/images/shelter_empty.webp" alt="Logo de" . {{ $association->nom }} . "bientôt visible">
      @else
        <img src="{{ $association->images_association[0]->url }}" class="rounded-lg"  alt="Logo de" . {{ $association->nom }}>
      @endif
    </div>

    <article class="font-body mx-auto w-[90%] md:w-[60%] bg-zoning rounded-lg shadow my-4">
      <div class="text-center w-full">
        <h3 class="font-grands text-xl md:text-3xl text-center my-1 w-full">Informations</h3>
      </div>

      <div class="w-full py-2 px-2 text-xs">
        @if ($association->description)
        <p class="font-body text-texte md:text-center md:text-lg">{{ $association->description }}</p>
        @else
        <p class="font-body text-texte md:text-center md:text-lg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus magni rerum, unde sunt beatae ipsam rem est sequi minus eligendi doloremque aliquid laudantium eos perspiciatis obcaecati ea voluptas harum et?</p>
        @endif
      </div>

      <div class="w-full px-2 py-4 gap-2 text-xs flex flex-col">
        <p class="font-body text-texte text-center md:text-base">Adresse : {{ $association->rue }},&nbsp;{{ $association->code_postal }},&nbsp;{{ $association->commune}},&nbsp;{{ $association->pays }}</p>
        <p class="font-body text-texte text-center md:text-base">Téléphone : {{ $association->telephone }}</p>
		@if ($association->site) <p class="font-body text-texte text-center md:text-base">E-mail : {{ $association->site }}</p> @endif
      </div>
    </article>
  </section>

  @if (count($pensionnaires) > 0)
    <section class="p-2 block">
      <h2 class="font-grands text-xl text-center my-2 md:md:text-2xl">Ils vous y attendent de patte ferme !</h2>
		<section id="animal-carousel" class="md:flex md:flex-row relative mx-auto h-auto w-[90%] bg-zoning rounded-lg shadow dark:bg-gray-800">

			<button
			class="absolute top-0 start-0 z-1 flex items-center justify-center h-full pl-2 cursor-pointer group focus:outline-none size-10 opacity-75"
			type="button" id="previous" aria-label="Précédent" tabindex="0"><img src="/icons/left.svg" alt=""></button>

			<div class="h-auto w-auto flex rounded-lg p-4 md:my-6 md:gap-4 md:px-8">
				@foreach ($pensionnaires as $animal)
					<div class="hidden carousel-img" >
						<div class="flex bg-fond rounded-lg shadow dark:bg-gray-800 flex-row md:flex-col mx-auto my-2 w-[75%] p-4">
							<div class="w-full md:w-full flex justify-center items-center">
								@if (empty($animal->images_animal))
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="/images/animal_empty.webp" alt="Photo à venir">
							 	@else
									<img class="object-contain w-[80%] h-48 md:h-full rounded-lg" src="{{ $animal->images_animal[0]->url}}" alt="Photo de" . {{ $animal->nom}}>
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
  @endif
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/carousel.js') }}" async></script>
@endpush
