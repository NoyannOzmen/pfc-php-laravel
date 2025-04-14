@extends('layouts.app')
@section('content')
<main class="justify-self-stretch flex-1">
	<h2 class="font-grands text-3xl text-center my-2 pt-10">Connexion</h2>

    <!-- <div class="text-center w-full py-2 font-grands font-base text-accents1"> security error message </div> -->

	<section class="pt-10">
		<div class="font-body mx-auto w-[80%] md:w-[60%] bg-zoning rounded-lg shadow dark:bg-gray-800">

			<form class="flex flex-col flex-wrap justify-around text-texte" method="POST">
            @csrf
				<div class="mx-auto p-2 w-[60%]">
					<label class="text-center" for="email">Votre e-mail</label>
					<input class="block bg-fond w-full" type="email" placeholder="jo.jo@morioh.io" name="_username" id="email" autocomplete="email" required/>
				</div>
				<div class="mx-auto p-2 w-[60%]">
					<label class="text-center" for="password">Votre mot de passe</label>
					<input class="block bg-fond w-full" type="password" placeholder="********" name="_password" id="password" autocomplete="current-password" required/>
				</div>
				<button class="w-[60%] mx-auto my-3 py-2 px-4 bg-accents1-light text-fond transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg" type="submit">Se connecter</button>
			</form>

                <!-- <div class="flash-notice font-grands font-base text-accents1 text-center">
                    app flashes notic message
                </div> -->

        </div>
	</section>
</main>
@endsection
