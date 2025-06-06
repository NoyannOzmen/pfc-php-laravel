@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
	<div class="my-12 flex items-center justify-center">
		<img src="/images/404.webp" class="" alt="Un lion choqué">
	</div>

	<h2 class="font-grands text-center my-3 pt-2">Cette page n'existe pas !</h2>
	<p class="font-body text-center my-6 pt-2">Mais vous pouvez reprendre la navigation depuis le menu en haut de la page <br> ou cliquer sur le Chat pour revenir à l'accueil !</p>

	<div class="flex items-center justify-center">
		<a href="/">
			<img src="/images/logo.svg" class="size-20 my-2" alt="Retour à l'accueil">
		</a>
	</div>
</main>
@endsection
