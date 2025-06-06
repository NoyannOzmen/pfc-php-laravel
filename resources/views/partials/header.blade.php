<header id="top" class="w-screen flex flex-row bg-zoning shadow-xl flex-none">

    <a class="flex flex-row grow-0 p-4" href="/">
      <img src="/images/logo.svg" alt="Logo de Pet Foster Connect" class="size-20">
      <div class="grow-0 py-4 px-2">
        <h1 class="stroke-title font-grands pt-2">Pet&nbsp;Foster<br>Connect</br></h1>
        <p>"Plateforme&nbsp;Française d'acCueil"</p>
      </div>
    </a>

    <div tabindex="0" class="hamburger absolute top-0 right-4 p-4">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <div class="grow-1 flex flex-col md:flex-row flex-auto max-[767px]:nav-links" id="nav-links">

      <div class="flex flex-auto flex-col place-self-center w-full md:w-[625px] md:flex-row-reverse md:absolute md:top-0 md:right-0">

        <nav class="rounded-br-lg md:rounded-b-lg flex-auto  bg-accents2-dark text-fond p-3 text-base md:text-lg md:mr-4">
          <ul class="flex flex-col md:flex-row flex-nowrap justify-around">
            <!-- Login Navigation -->
            @auth
              <li class="border-2 border-accents2-dark max-[767px]:border-b-fond md:mr-4 md:border-r-fond px-4 max-[767px]:pb-2 place-self-center md:place-self-start pl-2">
                @if (Auth::user()->refuge)
                  <a href="/association/profil">Bonjour : {{ Auth::user()->refuge->nom }}</a>
                @endif

                @if (Auth::user()->accueillant)
                    <a href="/famille/profil"> Bonjour : {{ Auth::user()->accueillant->prenom ? Auth::user()->accueillant->prenom : Auth::user()->accueillant->nom }}</a>
                @endif
              </li>
              @if (Auth::user()->refuge)
                <li class="border-2 border-accents2-dark mr-0 max-[767px]:border-b-fond  md:border-r-fond px-4 pr-6 max-[767px]:pb-2 place-self-center md:place-self-start">
                  <a tabindex=0 class="hover:text-accents1-light" href="/association/profil/animaux">Tableau de&nbsp;bord</a>
                </li>
              @endif
              @if (Auth::user()->accueillant)
                <li class="border-2 border-accents2-dark mr-0 max-[767px]:border-b-fond  md:border-r-fond px-4 pr-6 max-[767px]:pb-2 place-self-center md:place-self-start">
                  <a tabindex=0 class="hover:text-accents1-light" href="/famille/profil">Mon&nbsp;profil</a>
                </li>
              @endif
              <li id="log-out" class="border-2 border-accents2-dark place-self-center md:place-self-start pl-2">
                <a href="/deconnexion" class="hover:text-accents1-light">Se Déconnecter</a>
              </li>
            @else
              <li id="log-in" class="border-2 border-accents2-dark max-[767px]:border-b-fond md:mr-4 md:border-r-fond px-4 max-[767px]:pb-2 place-self-center md:place-self-start pl-2">
                <a href="/connexion" class="hover:text-accents1-light">Se Connecter</a>
              </li>
              <li id="register" class="md:mr-4 px-4 max-[767px]:pb-2 place-self-center pl-2">
                <a href="/inscription" class="hover:text-accents1-light item-link">S'inscrire</a>
              </li>
            @endauth
          </ul>
        </nav>

          <!-- Social Media Navigation -->
          <nav class="flex flex-row flex-auto justify-center p-3 gap-2">
            <a href="#" class="" tabindex="-1">
              <!-- Icone FB -->
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35" viewBox="0,0,256,256">
                <g fill="#fffbe4" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter"
                stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                  <g transform="scale(8.53333,8.53333)">
                    <path class="justify-center"
                    d="M15,3c-6.627,0 -12,5.373 -12,12c0,6.016 4.432,10.984 10.206,11.852v-8.672h-2.969v-3.154h2.969v-2.099c0,-3.475 1.693,-5 4.581,-5c1.383,0 2.115,0.103 2.461,0.149v2.753h-1.97c-1.226,0 -1.654,1.163 -1.654,2.473v1.724h3.593l-0.487,3.154h-3.106v8.697c5.857,-0.794 10.376,-5.802 10.376,-11.877c0,-6.627 -5.373,-12 -12,-12z">
                    </path>
                  </g>
                </g>
              </svg>
            </a>

            <a href=# class="" tabindex="-1">
              <!-- Icone Instagram -->
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35" viewBox="0,0,256,256">
                <g fill="#fffbe4" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter"
                stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                  <g transform="scale(10.66667,10.66667)">
                    <path
                    d="M8,3c-2.761,0 -5,2.239 -5,5v8c0,2.761 2.239,5 5,5h8c2.761,0 5,-2.239 5,-5v-8c0,-2.761 -2.239,-5 -5,-5zM18,5c0.552,0 1,0.448 1,1c0,0.552 -0.448,1 -1,1c-0.552,0 -1,-0.448 -1,-1c0,-0.552 0.448,-1 1,-1zM12,7c2.761,0 5,2.239 5,5c0,2.761 -2.239,5 -5,5c-2.761,0 -5,-2.239 -5,-5c0,-2.761 2.239,-5 5,-5zM12,9c-1.65685,0 -3,1.34315 -3,3c0,1.65685 1.34315,3 3,3c1.65685,0 3,-1.34315 3,-3c0,-1.65685 -1.34315,-3 -3,-3z">
                    </path>
                  </g>
                </g>
              </svg>
            </a>
          </nav>
      </div>

      <!-- Menu Navigation -->
      <nav class="flex flex-auto grow-1  place-self-center md:place-self-end pb-4 pr-4 text-m md:text-base xl:text-xl">
        <ul class="flex flex-auto flex-col md:flex-row md:place-content-end md:gap-5 pl-4 gap-2">
              <li class="hover:text-accents1-light place-self-start">
                <a  tabindex=0 class=# href="/animaux">Nos Animaux</a>
              </li>
              <li class="hover:text-accents1-light place-self-start">
                <a tabindex=0 class=# href="/associations">Nos Partenaires</a>
              </li>
              <li class="hover:text-accents1-light place-self-start">
                <a tabindex=0 class=# href="/a-propos">Qui sommes&#x2011;nous&nbsp;?</a>
              </li>
              <li class="hover:text-accents1-light place-self-start">
                <a tabindex=0 class=# href="/faq">Foire aux Questions</a>
              </li>
              <li class="hover:text-accents1-light place-self-start">
                <a tabindex=0 class=# href="/devenir-famille-d-accueil">Devenez Famille&nbsp;d'accueil</a>
              </li>
        </ul>
      </nav>
    </div>
  </header>
