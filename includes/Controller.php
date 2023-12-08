<?php
$controller_content = "<?php
/*
FIND AND REPLACE
\{SECTION-camelUp}: Namespace 
{SECTION-camelUp}/: inertia modules
{SECTION-camelPl}.: Permissions
{DEFAULT SORT COLUMN}
*/
declare(strict_types = 1);

namespace App\Http\Controllers\{SECTION-camelUp};

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\\" . $text['camelUpper']['singular'] . ";

use App\Imports\\" . $text['camelUpper']['plural'] . "Import;
use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class " . $text['camelUpper']['plural'] . "Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function index(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        \$sortColumns = Request::filled('sort_columns') ? Request::input('sort_columns') : ['{DEFAULT SORT COLUMN}'];
        \$sortOrders = Request::filled('sort_orders') ? Request::input('sort_orders') : ['asc'];
        \$sort = array_combine(\$sortColumns, \$sortOrders);

        try {
            $" . $text['camel']['plural'] . " = " . $text['camelUpper']['singular'] . "
            ::sort(\$sort)
            ->filter(Request::only('search', 'trashed'$controller_filter_list))
            ->paginate(Request::filled('per_page') ? (int)Request::input('per_page') : 50)
            ->withQueryString()
            ->through(fn ($variable_obj_name) => [
$field_list_controller_index            ]);
        } catch (\Exception \$e) {
            Session::flash('error', \$e->getMessage());
            Log::debug(\$e->getMessage());
            $" . $text['camel']['plural'] . " = [];
        }

        return Inertia::render('{SECTION-camelUp}/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "Index', [
            'filters' => Request::all('search', 'trashed'),
            'sort_columns' => Request::filled('sort_columns') ? Request::input('sort_columns') : [],
            'sort_orders' => Request::filled('sort_orders') ? Request::input('sort_orders') : [],
            '" . $text['camel']['plural'] . "' => $" . $text['camel']['plural'] . ",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function create(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        return Inertia::render('{SECTION-camelUp}/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "Create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse | \Inertia\Response
     */
    public function store(): \Illuminate\Http\RedirectResponse | \Inertia\Response
    {
        $variable_obj_name = " . $text['camelUpper']['singular'] . "::create(Request::validate(" . $text['camelUpper']['singular'] . "::getValidationArray()));
        Session::flash('success', '" . $text['spacedUpper']['singular'] . " Created Successfully.');
        if (Auth::user()->hasPermission('{SECTION-camelPl}." . $text['camel']['plural'] . ".edit')) {
            return redirect(url()->current() . '/' . " . $variable_obj_name . "->id . '/edit');
            return redirect()->action([" . $text['camelUpper']['plural'] . "Controller::class, 'edit'], ['" . $text['camel']['singular'] . "' => $variable_obj_name]);
        } else {
            return redirect(url()->current());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  " . $text['camelUpper']['singular'] . "  " . $variable_obj_name . "
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(" . $text['camelUpper']['singular'] . " " . $variable_obj_name . "): \Illuminate\Http\JsonResponse
    {
        request()->session()->reflash();
        return response()->json(['" . $text['camel']['singular'] . "' => " . $variable_obj_name . "]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  " . $text['camelUpper']['singular'] . " $variable_obj_name
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function edit(" . $text['camelUpper']['singular'] . " $variable_obj_name): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        if (Session::has('fromListing') || \$this->previousIsIndex()) {
            Session::flash('fromListing', true);
        }

        return Inertia::render('{SECTION-camelUp}/" . $text['camelUpper']['plural'] . "/" . $text['camelUpper']['singular'] . "Edit', [
            '" . $text['camel']['singular'] . "' => $variable_obj_name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  " . $text['camelUpper']['singular'] . " $variable_obj_name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(" . $text['camelUpper']['singular'] . " $variable_obj_name): \Illuminate\Http\RedirectResponse
    {
        Session::keep(['fromListing']);
        " . $variable_obj_name . "->update(Request::validate(" . $text['camelUpper']['singular'] . "::getValidationArray()));
        return redirect()->back()->with('success', '" . $text['spacedUpper']['singular'] . " Updated Successfully.');
    }

    /**
     * Remove specified resource using soft delete.
     *
     * @param  " . $text['camelUpper']['singular'] . " $variable_obj_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(" . $text['camelUpper']['singular'] . " $variable_obj_name): \Illuminate\Http\JsonResponse
    {
        " . $variable_obj_name . "->delete();
        return response()->json(['flash' => ['success' => '" . $text['spacedUpper']['singular'] . " was removed.']]);
    }

    /**
     * Restore specified resource using soft delete.
     *
     * @param  " . $text['camelUpper']['singular'] . " $variable_obj_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(" . $text['camelUpper']['singular'] . " $variable_obj_name): \Illuminate\Http\JsonResponse
    {
        " . $variable_obj_name . "->restore();
        return response()->json(['flash' => ['success' => '" . $text['spacedUpper']['singular'] . " was restored.']]);
    }

    /**
     * Export records as displayed on listing screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export()
    {
        \$collection = " . $text['camelUpper']['singular'] . "
            ::filter(Request::only('search', 'trashed'$controller_filter_list))
            ->get()
            ->makeHidden(['id', 'created_at', 'updated_at', 'deleted_at']);
        \$headings = [$field_list_quoted];
        return Excel::download(new CollectionExport(\$collection, \$headings), '" . $text['spacedUpper']['singular'] . ".xlsx');
    }

    /**
     * Import records as displayed on listing screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        try {
            Excel::import(new " . $text['camelUpper']['plural'] . "Import, request()->file('fileImport'));
            return redirect()->back()->with('success', 'Import Complete');
        } catch (\Maatwebsite\Excel\Validators\ValidationException \$e) {
            \$message = '';
            \$failures = \$e->failures();

            foreach (\$failures as \$failure) {
                \$failure->row(); // int row
                \$failure->attribute(); // string heading key or column index
                \$failure->errors(); // Array error messages from Laravel validator
                \$failure->values(); // Array values of the row that has failed.
                \$message .= \"Error on row \$failure->row(), column \$failure->attribute(): \" . implode('<br/>', \$failure->errors());
            }

            return redirect()->back()->with('error', \$message);
        }
    }

    private function previousIsIndex()
    {
        \$urlPieces = explode('?', url()->previous());
        return \$urlPieces[0] === action([" . $text['camelUpper']['plural'] . "Controller::class, 'index']);
    }
}
";

if (!is_dir('generated/app/Http/Controllers')) {
    mkdir('generated/app/Http/Controllers', 0777, true);
}
$file = fopen('generated/app/Http/Controllers/'. $text['camelUpper']['plural'] . 'Controller.php', "w");
fputs($file, $controller_content);
fclose($file);
