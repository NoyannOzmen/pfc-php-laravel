@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
	<h2 class="font-grands text-3xl text-center my-2 pt-5">Nous contacter</h2>
	<section class="font-body text-center text-texte">
		<article class="bg-zoning font-body mx-auto w-[60%] rounded-lg shadow dark:bg-gray-800 my-2 py-5">
			<h3 class="text-2xl mb-4">Par téléphone :</h3>
			<a href="tel:+33XXXXXXXXX">+33X.XX.XX.XX.XX</a>
			<p>Du lundi au vendredi : 9h - 18h</p>
		</article>
		<article class="bg-zoning font-body mx-auto w-[60%] rounded-lg shadow dark:bg-gray-800 my-2 py-5">
			<img class="mx-auto" src="/images/shelter_empty.webp" alt="Une jolie photo des locaux">
			<h3 class="text-2xl mb-4">Sur place ou par courrier :</h3>
			<p>9 rue de l'Arche de Noé, 50450 LA BALEINE, France </p>
			<p>Du lundi au vendredi : 10h - 17h30</p>
		</article>
	</section>

	<section>
		<div class="font-body mx-auto w-[60%] bg-zoning rounded-lg shadow dark:bg-gray-800 my-2">
			<h4 class="text-2xl mb-4 text-center my-2 py-4">Nous contacter directement</h4>

			<form class="flex flex-col flex-wrap justify-around text-texte" action="mailto:#" method="POST">
            @csrf
				<div class="mx-auto w-[60%] p-2">
					<label class="text-center" for="prenom">Votre Prénom</label>
					<input class="block bg-fond w-full" type="text" placeholder="Giorno" name="prenom" id="prenom" required />
				</div>
				<div class="mx-auto w-[60%] p-2">
					<label class="text-center" for="nom">Votre Nom</label>
					<input class="block bg-fond w-full" type="text" placeholder="Giovanna" name="nom" id="nom" required />
				</div>
				<div class="mx-auto w-[60%] p-2">
					<label class="text-center" for="email">Votre E-mail</label>
					<input class="block bg-fond w-full" type="email" placeholder="jo.jo@morioh.io" name="email" id="email" required />
				</div>
				<div class="mx-auto w-[60%] p-2">
					<label class="text-center" for="msg">Votre Message</label>
					<textarea class="block bg-fond w-full" id="msg" name="msg" rows="5" cols="30" placeholder="J'aime beaucoup les tortues, merci de penser à elles !" required></textarea>
				</div>
				<button class="w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Envoyer</button>
			</form>
		</div>
	</section>
</main>
@endsection
