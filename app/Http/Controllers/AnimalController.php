<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Demande;
use App\Models\Espece;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display available animals in a list.
     */
    public function displayAll(): View
    {
        return view('animaux/animalList', ['animals' => Animal::all(), 'especes' => Espece::all(), 'tags' => Tag::all()]);
    }

    /**
     * Handle search for animals.
     */
    public function getSearched(Request $request): View
    {
        $query =  Animal::where('statut', 'En refuge');

        $speciesFull = $request->request->get('_especeDropdownFull');
        $speciesSmall = $request->request->get('_especeDropdownSmall');
        $sexe = $request->request->get('_sexe');
        $minAge = $request->request->get('_minAge');
        $maxAge = $request->request->get('_maxAge');
        /* $dpt = $request->request->get('_dptSelect'); */
        /* $tags = $request->request->get('_tags'); */

        if ($request->has('_especeDropdownSmall')) {
            $query->where('espece_id', "$speciesSmall");
        };

        if ($request->has('_especeDropdownFull')) {
            $query->where('espece_id', "$speciesFull");
        };

        if ($request->has('_sexe')) {
            $query->where('sexe', "$sexe");
        };

        if ($request->has('_minAge')) {
            $query->where('age', '>', "$minAge");
        };

        if ($request->has('_maxAge')) {
            $query->where('age', '<', "$maxAge");
        };

        /* if ($request->has('_dptSelect'))  {
            $query->where('refuge.code_postal', 'LIKE', "$dpt%");
        }; */

        /* if ($tags = $request->has('_tags')) {
            $query->where('tags.nom', 'NOT IN', $tags);
        }; */

        $searchedAnimals = $query->get();

        return view('animaux/animalSearchResults', ['searchedAnimals' => $searchedAnimals]);
    }


    /**
     * Display single animal page.
     */
    public function animal_details($id): View
    {
        return view('animaux/animalDetails', ['animal' => Animal::findOrFail($id)]);
    }

    /**
     * [LOGGED USER] Create a new foster request
     */
    public function make_request($id): View
    {
        $animal = Animal::findOrFail($id);
        //! REMOVE HARDCODED
        $user = 1;

        $request = Demande::firstOrCreate(
            ['animal_id' => $animal->id],
            ['famille_id' => $user],
            ['statut_demande' => 'En attente', 'date_debut' => date('Y/m/d'), 'date_fin' => date('Y/m/d', strtotime('+1 year'))]
        );

        if ($request->exists) {
            $message = 'Votre demande a bien été prise en compte !';
        } else {
            $message = 'Vous avez déjà effectué une demande pour cet animal !';
        }

        return view('animaux/animalDetails', ['animal' => $animal, 'notice' => $message]);
    }
}
