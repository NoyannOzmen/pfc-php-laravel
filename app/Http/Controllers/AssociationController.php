<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Espece;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssociationController extends Controller
{
    /**
     * Display shelters in a list.
     */
    public function displayAll(): View
    {
        return view('association/associationList', ['associations' => Association::all(), 'especes' => Espece::all(), 'tags' => Tag::all()]);
    }

    /**
     * Handle search for shelters.
     */
    public function getSearched(Request $request): View
    {
        $query =  Association::where('nom', 'IS NOT', null);

        /* $species = $request->request->get('_especes'); */
        $dptFull = $request->request->get('_dptSelectFull');
        $dptSmall = $request->request->get('_dptSelectSmall');
        $name = $request->request->get('_shelterNom');

        if ($name) {
            $query->where('nom', 'LIKE' , "%$name%");
        };

        if ($dptSmall)  {
            $query->where('code_postal', 'LIKE', "$dptSmall%");
        };

        if ($dptFull)  {
            $query->where('code_postal', 'LIKE', "$dptFull%");
        };

        /* if ($species) {
            $query->whereIn('pensionnaires.espece.nom', $species);
        }; */

        $searchedShelters = $query->get();

        return view('association/associationSearchResults', ['searchedShelters' => $searchedShelters]);
    }


    /**
     * Display single animal page.
     */
    public function shelter_details($id): View
    {
        $association = Association::findOrFail($id);
        $pensionnaires = $association->pensionnaires->where("statut", "En refuge");
        return view('association/associationDetails', ['association' => $association, "pensionnaires" => $pensionnaires]);
    }

}
