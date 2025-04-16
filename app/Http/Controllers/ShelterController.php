<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalTag;
use App\Models\Association;
use App\Models\Demande;
use App\Models\Espece;
use App\Models\Media;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShelterController extends Controller
{
    /**
     * Display Shelter profile.
     */
    public function shelter_dashboard(): View
    {
        $userId = Auth::user()->refuge->id;


        return view('shelter/dashInfos', ['association' => Association::findOrFail($userId)]);
    }

    /**
     * Handle info updates.
     */
    public function shelter_edit(Request $request): View
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        $request->validate([
            'nom' => 'bail|required|string',
            'responsable' => 'bail|required|string',
            'rue' => 'bail|required|string',
            'commune' => 'bail|required|string',
            'code_postal' => ['bail','required','regex:/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/'],
            'pays' => 'bail|required|string',
            'telephone' => ['bail','required','regex:/^(0|\+33 )[1-9]([\-. ]?[0-9]{2} ){3}([\-. ]?[0-9]{2})|([0-9]{8})$/'],
            'siret' => ['bail','required','regex:/^(\d{14}|((\d{3}[ ]\d{3}[ ]\d{3})|\d{9})[ ]\d{5})$/'],
            'site' => 'nullable|url:http,https',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $request->whenHas($key, fn ($value) => $association->$key = $value);
        }

        $association->save();

        return view('shelter/dashInfos', ['association' => $association]);
    }

    /**
     * Handle account deletion.
     */
    public function shelter_destroy(Request $request): RedirectResponse
    {
        $userId = Auth::user()->refuge->id;
        $user = User::find(Auth::user()->id);

        $association = Association::findOrFail($userId)->first();

        $sheltered = Animal::where('association_id', $userId)->get();

        if (count($sheltered) > 0) {
            $association->delete();
            $user->delete();
            //* Possibly add soft-delete ?
            return redirect('/deconnexion');
        };

        return back()->with("association", $association)->with('error', 'Vous accueillez actuellement un ou plusieurs animaux enregistrés sur notre site.
            Merci de contacter un administrateur afin de supprimer votre compte !');
    }

    /**
     * Display Logo upload page.
     */
    public function shelter_logo(): View
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        return view("shelter/dashLogo", ["association" => $association]);
    }

    /**
     * Upload logo
     */
    public function shelter_logo_upload(Request $request): RedirectResponse
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $fileName = $request->file('file')->hashName();
        $path = $request->file('file')->storePubliclyAs(
            'images/animaux',
            $fileName,
            'uploads'
        );

        $extension = $request->file('file')->extension();
        if(in_array($extension,["jpeg","jpg","png","webp","gif"]))
        {
            $webp = public_path().'/'.$path;
            $im = imagecreatefromstring(file_get_contents($webp));
            imagepalettetotruecolor($im);
            $new_webp = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $webp);
            unlink($webp);
            imagewebp($im, $new_webp, 50);

            $image = new Media;
            $image->url = '/images/animaux/' . preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $fileName);
            $image->ordre = 1;
            $image->association_id = $userId;
            $image->save();
        };

        return redirect("association/profil/logo")->with("association", $association);
    }

    //* Animals
    /*.
     * Display Sheltered animals.
     */
    public function shelter_animals_list(): View
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        $animals = Animal::all()->where("association_id", $userId);

        return view("shelter/dashAnimauxList", ["association" => $association, "especes" => Espece::all(), 'animals' => $animals ]);
    }

    /**
     * Displayed Fostered animals.
     */
    public function shelter_fostered_animals(): View
    {
        $userId = Auth::user()->refuge->id;

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
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        $animal = Animal::findOrFail($id);
        $demandes = Demande::all()->where('animal_id', $id);

        return view("shelter/dashAnimauxDetails", ["association" => $association, 'animal' => $animal, 'demandes' => $demandes, 'tags' => Tag::all()]);
    }

    public function shelter_animal_picture_upload($id, Request $request): RedirectResponse
    {
        $animal = Animal::findOrFail($id);

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $fileName = $request->file('file')->hashName();
        $path = $request->file('file')->storePubliclyAs(
            'images/animaux',
            $fileName,
            'uploads'
        );

        $extension = $request->file('file')->extension();
        if(in_array($extension,["jpeg","jpg","png","webp","gif"])){
            $webp = public_path().'/'.$path;
            $im = imagecreatefromstring(file_get_contents($webp));
            imagepalettetotruecolor($im);
            $new_webp = preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $webp);
            unlink($webp);
            imagewebp($im, $new_webp, 50);

            $newPic = new Media;
            $newPic->url = '/images/animaux/' . preg_replace('"\.(jpg|jpeg|png|gif|webp)$"', '.webp', $fileName);
            $newPic->ordre = 1;
            $newPic->animal_id = $id;
            $newPic->save();
        };

        return back()->with("id", $id);
    }

    /**
     * Display new profile creation page
     */
    public function shelter_display_create_animal(): View
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);


        return view("shelter/dashAnimauxCreate", ["association" => $association, "especes" => Espece::all(), "tags" => Tag::all()]);
    }

    /**
     * Handle animal profile creation
     */
    public function shelter_create_animal(Request $request): RedirectResponse
    {
        $userId = Auth::user()->refuge->id;

        $animalForm = $request->request->get('create_animal');
        $tagForm = $request->request->get('create_tag');

        if ($request->has($animalForm)) {
            $request->validate([
                "_nom_animal" => 'bail|required|string',
                "_sexe_animal" => 'bail|required|string',
                "_age_animal" => 'bail|required|integer',
                "_espece_animal" => 'bail|required|integer',
                "_race_animal" => 'string',
                "_couleur_animal" => 'bail|required|string',
                "_description_animal" => 'bail|required|string',
            ]);

            $name = $request->request->get('_nom_animal');
            $sex = $request->request->get('_sexe_animal');
            $age = $request->request->get('_age_animal');
            $species = $request->request->get('_espece_animal');
            $race = $request->request->get('_race_animal');
            $colour = $request->request->get('_couleur_animal');
            $description = $request->request->get('_description_animal');

            $newAnimal = new Animal;

            $newAnimal->nom = $name;
            $newAnimal->sexe = $sex;
            $newAnimal->age = $age;
            $newAnimal->espece_id = $species;
            if ($race) {
                $newAnimal->race = $race;
            };
            $newAnimal->couleur = $colour;
            $newAnimal->description = $description;
            $newAnimal->association_id = $userId;
            $newAnimal->statut = 'En Refuge';

            $newAnimal->save();

            $animalTags = $request->input('_tag');

            if (count($animalTags) > 0) {
                foreach($animalTags as $AniTag) {
                    $newTag = new AnimalTag();
                    $newTag->animal_id = $newAnimal->id;
                    $newTag->tag_id = $AniTag;
                }
            }

            $newPhoto = new Media;
            $newPhoto->ordre = 1;
            $newPhoto->animal_id = $newAnimal->id;
            $newPhoto->url = '/images/animal_empty.webp';
            $newPhoto->save();

            return back()->with('error', 'Profil animal créé avec succès');
        }

        if ($request->has($tagForm)) {
            $request->validate([
                "_name_tag" => 'required|string',
                "_desc_tag" => 'required|string'
            ]);

            $tagName = $request->request->get('_name_tag');
            $tagDesc = $request->request->get('_desc_tag');

            $newTag = new Tag;
            $newTag->nom = $tagName;
            $newTag->description = $tagDesc;
            $newTag->save();

            return back()->with('error', 'Nouveau tag créé avec succès');
        }

        return redirect("association/profil/animaux/nouveau-profil");
    }

    //* Requests
    /**
     * Display current pending requests
     */
    public function shelter_requests(): View
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);

        $requestedAnimals = Animal::all()->where("association_id", $userId)->where("statut", "En refuge");

        return view("shelter/dashDemandes", ["association" => $association, 'requestedAnimals' => $requestedAnimals]);
    }

    /**
     * Display specific request details.
     */
    public function shelter_request_details($demandeId): View
    {
        $userId = Auth::user()->refuge->id;

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
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);
        $request = Demande::findOrFail($demandeId);

        $request->statut_demande = "Validée";
        $request->save();

        $animal = Animal::find($request->animal_accueillable->id);

        $otherRequests = Demande::where('animal_id', '=', $animal->id)->where('statut_demande', '=', 'En attente')->get();
        foreach($otherRequests as $other) {
            $other->statut_demande = 'Refusée';
            $other->save();
        }

        return redirect("association/profil/demandes/$demandeId")->with("association", $association)->with("request", $request);
    }

    /**
     * Deny current request.
     */
    public function shelter_deny_request($demandeId): RedirectResponse
    {
        $userId = Auth::user()->refuge->id;

        $association = Association::findOrFail($userId);
        $request = Demande::findOrFail($demandeId);

        $request->statut_demande = "Refusée";
        $request->save();

        return redirect("association/demandes/$demandeId")->with("association", $association)->with("request", $request);
    }
}
