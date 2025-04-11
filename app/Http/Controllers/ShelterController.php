<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalTag;
use App\Models\Association;
use App\Models\Demande;
use App\Models\Espece;
use App\Models\Media;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    /**
     * Display Shelter profile.
     */
    public function shelter_dashboard(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;

        return view('shelter/dashInfos', ['association' => Association::findOrFail($userId)]);
    }

    /**
     * Handle info updates.
     */
    public function shelter_edit(Request $request): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $nom = $request->request->get('_nom');
        $responsable = $request->request->get('_responsable');
        $rue = $request->request->get('_rue');
        $commune = $request->request->get('_commune');
        $code_postal = $request->request->get('_code_postal');
        $pays = $request->request->get('_pays');
        $telephone = $request->request->get('_telephone');
        $siret = $request->request->get('_siret');
        $site = $request->request->get('_site');
        $description = $request->request->get('_description');

        if ($request->has("_nom")) {$association->nom($nom);};
        if ($request->has("_responsable")) {$association->responsablee($responsable);};
        if ($request->has("_rue")) {$association->rue($rue);};
        if ($request->has("_commune")) {$association->commune($commune);};
        if ($request->has("_code_postal")) {$association->code_postal($code_postal);};
        if ($request->has("_pays")) {$association->pays($pays);};
        if ($request->has("_telephone")) {$association->telephone($telephone);};
        if ($request->has("_siret")) {$association->siret($siret);};
        if ($request->has("_site")) {$association->site($site);};
        if ($request->has("_description")) {$association->description($description);};

        $association->save();

        return view('shelter/dashInfos', ['association' => $association]);
    }

    /**
     * Handle account deletion.
     */
    public function shelter_destroy(): RedirectResponse
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $sheltered = Animal::where('association_id', $userId);

        if (!$sheltered) {
            $association->destroy();
            /* $user->destroy(); */
            //* Possibly add soft-delete ?
            return redirect("staticPages/accueil");
        }
        $message = 'Vous accueillez actuellement un ou plusieurs animaux enregistrés sur notre site.
            Merci de contacter un administrateur afin de supprimer votre compte !';

        return redirect("shelter/dashInfos", ["association" => $association, "message" => $message]);
    }

    /**
     * Display Logo upload page.
     */
    public function shelter_logo(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);
        //!TODO FIX FORM

        return view("shelter/dashLogo", ["association" => $association]);
    }

    /**
     * Upload logo
     */
    public function shelter_logo_upload(): RedirectResponse
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        //!TODO ADD LOGIC

        return redirect("shelter/dashLogo", ["association" => $association]);
    }

    //* ANIMAL RELATED METHODS

    /*.
     * Display Sheltered animals.
     */
    public function shelter_animals_list(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $animals = Animal::all()->where("association_id", $userId);

        return view("shelter/dashAnimauxList", ["association" => $association, "especes" => Espece::all(), 'animals' => $animals ]);
    }

    /**
     * Displayed Fostered animals.
     */
    public function shelter_fostered_animals(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        /* $animals = $association->pensionnaires->filter('statut', 'Accueilli'); */
        $animals = Animal::all()->where("association_id", $userId)->where("statut", "Accueilli");

        return view("shelter/dashAnimauxSuiviAccueil", ["association" => $association, "animals" => $animals, "tags" => Tag::all()]);
    }

    /**
     * Display specific animal details.
     */
    public function shelter_animal_details($id): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $animal = Animal::findOrFail($id);
        $demandes = Demande::all()->where('animal_id', $id);

        //!TODO ADD LOGIC

        return view("shelter/dashAnimauxDetails", ["association" => $association, 'animal' => $animal, 'demandes' => $demandes, 'tags' => Tag::all()]);
    }

    /**
     * Display new profile creation page
     */
    public function shelter_display_create_animal(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);


        return view("shelter/dashAnimauxCreate", ["association" => $association, "especes" => Espece::all(), "tags" => Tag::all()]);
    }

    /**
     * Handle animal profile creation
     */
    public function shelter_create_animal(Request $request): RedirectResponse
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $animalForm = $request->request->get('create_animal');
        $tagForm = $request->request->get('create_tag');

        if ($request->has($animalForm)) {
            $name = $request->request->get('_nom_animal');
            $sex = $request->request->get('_sexe_animal');
            $age = $request->request->get('_age_animal');
            $species = $request->request->get('_espece_animal');
            $espece = Espece::where($species);
            $race = $request->request->get('_race_animal');
            $colour = $request->request->get('_couleur_animal');
            $description = $request->request->get('_description_animal');

            $animalTags = $request->input('_tag');
            foreach($animalTags as $tag) {
                $tag = Tag::where($tag);
                $tagsToAdd[] = $tag;
            };

            $newAnimal = new Animal();
            $newAnimal->nom($name);
            $newAnimal->sexe($sex);
            $newAnimal->age($age);
            $newAnimal->espece($espece);
            if ($race) {
                $newAnimal->race($race);
            }
            $newAnimal->couleur($colour);
            $newAnimal->description($description);
            $newAnimal->refuge($association);
            if (count($tagsToAdd) > 0) {
                foreach ($tagsToAdd as $tagToAdd) {
                    $tag = AnimalTag::where($tagToAdd);
                    $newAnimal->tags($tag);
                }
            };
            $newAnimal->statut('En Refuge');
            $newAnimal->save();

            $animalId = $newAnimal->id;
            $newPhoto = new Media();
            $newPhoto->ordre(1);
            $newPhoto->animal_id($animalId);
            $newPhoto->url('/images/animal_empty.webp');
            $newPhoto->save();

            $message = "Profil animal créé avec succès";
        }

        if ($request->has($tagForm)) {
            $tagName = $request->request->get('_name_tag');
            $tagDesc = $request->request->get('_desc_tag');

            $newTag = new Tag();
            $newTag->nom($tagName);
            $newTag->description($tagDesc);
            $newTag->save();

            $message = "Nouveau tag créé avec succès";
        }

        return redirect("shelter/dashAnimauxCreate", ["message" => $message]);
    }


    //* REQUESTS RELATED METHODS
    /**
     * Display current pending requests
     */
    public function shelter_requests(): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $requestedAnimals = Animal::all()->where("association_id", $userId)->where("statut", "En refuge");

        return view("shelter/dashDemandes", ["association" => $association, 'requestedAnimals' => $requestedAnimals]);
    }

    /**
     * Display specific request details.
     */
    public function shelter_request_details($demandeId): View
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);

        $request = Demande::findOrFail($demandeId);
        $famille = $request->potentiel_accueillant;
        $animal = $request->animal_accueillable;

        return view("shelter/dashDemandeSuivi", ["association" => $association, "request" => $request, "famille" => $famille, "animal" => $animal]);
    }

    /**
     * Accept current request.
     */
    public function shelter_accept_request($demandeId): RedirectResponse
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);
        $request = Demande::findOrFail($demandeId);

        $request->statut_demande = "Validée";
        $request->save();

        //!TODO SET OTHERS TO DENIED

        return redirect("shelter/dashDemandesSuivi", ["association" => $association, "request" => $request]);
    }

    /**
     * Deny current request.
     */
    public function shelter_deny_request($demandeId): RedirectResponse
    {
        /* $userId = $user->refuge->id; */
        //!TODO REMOVE HARDCODED
        $userId = 1;
        $association = Association::findOrFail($userId);
        $request = Demande::findOrFail($demandeId);

        $request->statut_demande = "Refusée";
        $request->save();

        return redirect("shelter/dashDemandesSuivi", ["association" => $association, "request" => $request]);
    }
}
