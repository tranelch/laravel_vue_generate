<?php
//BEGIN CONFIG SETTINGS
$db_name = "demo";
$db_user = "root";
$db_password = "root";
$db_host = "localhost"; //usually localhost
$db_table_prefix = "";
$mysqli = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$exclude = ['migrations','oauth_access_tokens','oauth_auth_codes','oauth_clients','oauth_personal_access_clients',
    'oauth_refresh_tokens','password_resets','password_reset_tokens','personal_access_tokens','sessions','team_invitations','team_user','teams',
    'jobs',
];
//END CONFIG SETTINGS

require('includes/Pluralize.php');

$arrTableResult = $mysqli->query("SHOW TABLES FROM `$db_name`");
$routes = [
    'base' => "/* FIND AND REPLACE\n{SECTION-camelPl}. : permissions\n{SECTION-camelUp}\ : controller path*/\n\n",
    'lookup' => "\n\n    Route::prefix('lookup')->group(function () {

    }",
    'admin' => "\n\n    Route::prefix('admin')->group(function () {",
];
$permissionsSql = "/* FIND AND REPLACE\n{SECTION-camelPl}. \n{group_id}\n*/\n
    INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `ip_address`, `accepted_terms`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Chris', NULL, 'tranel@earthlinginteractive.com', '2023-12-06 20:25:02', '$2y$12\$krma209lNfeMYEWGJy/hVeAHOp.S0cMFNGTTWIDID4Rnez8CXsV5.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-12-06 19:37:01', '2023-12-06 20:25:02', NULL);
    INSERT INTO `acl_groups` (`id`, `name`, `guard_name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES 
        (1, 'admin', 'web', 'Admin', NULL,  NULL,  NULL),
        (2, 'mortal', 'web', 'Mortal', NULL,  NULL,  NULL);
    INSERT INTO `acl_model_has_groups` (`group_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\User', 1);
    INSERT INTO `acl_group_managed_groups` (`id`, `group_id`, `managed_group_id`) VALUES (1, 1, 1),(2, 1, 2);
    INSERT INTO `acl_permissions` (`id`, `name`, `guard_name`, `description`, `deleted_at`, `created_at`, `updated_at`)
    VALUES
        (NULL, 'admin.users.create', 'web', 'Create Users', NULL, NULL, NULL),
        (NULL, 'admin.users.edit', 'web', 'Edit Users', NULL, NULL, NULL),
        (NULL, 'admin.users.view', 'web', 'View Users', NULL, NULL, NULL),
        (NULL, 'admin.users.remove', 'web', 'Remove Users', NULL, NULL, NULL),
        (NULL, 'admin.users.restore', 'web', 'Restore Users', NULL, NULL, NULL)
        (NULL, 'users.groups.assign', 'web', 'Assign User Groups', NULL, NULL, NULL);
    INSERT INTO acl_group_has_permissions (SELECT pm.id, 1 FROM acl_permissions pm WHERE pm.name LIKE 'admin.users.%' AND NOT EXISTS(SELECT * FROM acl_group_has_permissions WHERE group_id = 1 AND permission_id = pm.id ));
    INSERT INTO acl_group_has_permissions (SELECT pm.id, 1 FROM acl_permissions pm WHERE pm.name LIKE 'users.groups.assign' AND NOT EXISTS(SELECT * FROM acl_group_has_permissions WHERE group_id = 1 AND permission_id = pm.id ));
    ";
$menuData = "/* FIND AND REPLACE\n{SECTION-camelPl}. : permissions\n/{SECTION-kabob} : route path\n*/\n\n[\n";

while ($table = $arrTableResult->fetch_array()[0]) { //iterate through tables
    if (str_starts_with($table, 'liq_') || str_starts_with($table, 'jos') || str_starts_with($table, 'failed') || str_starts_with($table, 'error') || str_starts_with($table, 'acl')) {
        continue;
    }
    if (in_array($table, $exclude)) {
        continue;
    }
    if ($db_table_prefix != '') {
        $has_correct_prefix = (strpos($table, $db_table_prefix) === 0);
    } else {
        $has_correct_prefix = true;
    }

    echo $table."<br />\n";

    if ($has_correct_prefix !== false) {
        $table = str_replace($db_table_prefix, '', $table);
        $text = getTextFormats($table);


        $variable_obj_name = '$' . $text['camel']['singular'];

        $field_list_quoted = '';
        $field_list_unquoted = '';
        $field_list_quoted_noids = '';
        $field_list_controller_index = '';
        $field_list_controller_validation = '';
        $controller_filter_list = '';
        $model_filter_text = '';
        $vue_form_definition = '';

        $vue_form_text = '';
        $vue_report_header = '';
        $vue_report_filter = '';
        $vue_info_line = '';
        $vue_report_line = "          <td class=\"actions\">
            <GridButton v-if=\"permissions.can(permissionBase + '." . $text['camel']['plural'] . ".view')\" @click=\"openModal(" . $text['camel']['singular'] . ")\" icon=\"eye\" title=\"Show\" />
            <GridButton v-if=\"permissions.can(permissionBase + '." . $text['camel']['plural'] . ".edit')\" icon=\"edit\" title=\"Edit\" :href=\"baseUrl + '/' + " . $text['camel']['singular'] . ".id + '/edit'\" />
            <GridButton v-if=\"canDeactivate(" . $text['camel']['singular'] . ")\" @click=\"remove(baseUrl + '/' + " . $text['camel']['singular'] . ".id + '/remove', " . $text['camel']['singular'] . ".name)\" icon=\"trash\" title=\"Deactivate\" />
            <GridButton v-if=\"canRestore(" . $text['camel']['singular'] . ")\" @click=\"restore(baseUrl + '/' + " . $text['camel']['singular'] . ".id + '/restore', " . $text['camel']['singular'] . ".name)\" icon=\"trash-restore\" title=\"Restore\" />
          </td>\n";

        $imports_line = '';
        $count = 0;

        $result = $mysqli->query("SHOW COLUMNS FROM `$db_name`.`" . $db_table_prefix . $table . "`");
        while ($fieldObj = $result->fetch_object()) {
            if (in_array($fieldObj->Field, ['sent_to_syncarto','syncarto_sync_started','created_at','updated_at'])) {
                continue;
            }

            $field = $fieldObj->Field;
            $field_label = str_replace('_', ' ', ucwords($field, "_"));

            $field_list_controller_index .= "                '$field' => $variable_obj_name->$field,\n";
            $field_list_quoted .= "'$field',";
            if (!str_ends_with($field, '_id') && $field != 'id' && $field != 'deleted_at') {
                $field_list_quoted_noids .= "'$field',";
            }

            if (in_array($field, ['deleted_at'])) {
                continue;
            }

            if ($field != 'id') {
                $vue_form_definition .= "      $field: props." . $text['camel']['singular'] . ".$field,\n";
                $vue_report_header .= "          <th class=\"sortable\" :class=\"sort.sortOrder('$field')\" @click=\"sort.addColumnToSort('$field', baseUrl, getFilterQueryString(form))\">$field_label</th>\n";
                if ($fieldObj->Type === 'tinyint(1)') {
                    $vue_report_line .= "          <td class=\"boolean\"><i v-if=\"" . $text['camel']['singular'] . "." . $field . "\" class=\"fas fa-check\" aria-hidden=\"true\" /><i v-else class=\"fas fa-times\" aria-hidden=\"true\" /></td>\n";
                } else {
                    $vue_report_line .= "          <td>{{ " . $text['camel']['singular'] . ".$field }}</td>\n";
                }
            }
            if (!str_ends_with($field, '_id') && $field != 'id') {
                if ($fieldObj->Type == 'datetime') {
                    $imports_line .= "            '$field' => \$row[$count] ? ExcelDate::excelToDateTimeObject(\$row[$count])->format('Y-m-d H:i:s') : null,\n";
                } elseif ($fieldObj->Type == 'date') {
                    $imports_line .= "            '$field' => \$row[$count] ? ExcelDate::excelToDateTimeObject(\$row[$count])->format('Y-m-d') : null,\n";
                } elseif ($fieldObj->Type == 'time') {
                    $imports_line .= "            '$field' => \$row[$count] ? ExcelDate::excelToDateTimeObject(\$row[$count])->format('H:i:s') : null,\n";
                } else {
                    $imports_line .= "            '$field' => \$row[$count],\n";
                }
                if ($count % 2 === 0 && $count > 0) {
                    $vue_info_line .= "    </div>\n    <hr class=\"my-3\" />\n    <div class=\"grid grid-cols-1 lg:grid-cols-2 gap-4\">\n";
                }
                if ($fieldObj->Type === 'tinyint(1)') {
                    $vue_info_line .= "      <div>\n        <i v-if=\"" . $text['camel']['singular'] . ".$field\" class=\"fas fa-check\" aria-hidden=\"true\" />\n        <i v-else class=\"fas fa-times\" aria-hidden=\"true\" />\n        <strong class=\"block\">$field_label</strong>\n      </div>\n";
                } else {
                    $vue_info_line .= "      <div>\n        <strong class=\"block\">$field_label</strong>\n        <span v-if=\"" . $text['camel']['singular'] . ".$field\" class=\"block\">{{ " . $text['camel']['singular'] . ".$field }}</span>\n      </div>\n";
                }
                $count++;
            }

            // begin long if..else switch
            if ($field == 'id') {
                //$vue_form_text .= "      <input type=\"hidden\" v-model=\"form.id\" id=\"id\" name=\"id\" />\n";
            } elseif (str_ends_with($field, '_id')) {
                $field_list_controller_validation .= "            '$field' => ['nullable', " . "'integer'],\n";
                $vue_form_text .= "      <ApiLookup v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" multiple=\"multiple\" displayField=\"name\" lookup_url=\"/lookup/".$field."_lookup\" @input=\"onSelected" . $text['camelUpper']['singular'] . "\" placeholder=\"Select your $field_label\" :error=\"errors.$field\" />\n";
            } elseif (str_contains($fieldObj->Type, 'datetime')) {
                $field_list_controller_validation .= "            '$field' => ['nullable', 'date'],\n";
                $vue_form_text .= "      <FormsDateTimeInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            }
            /*elseif(str_contains($fieldObj->Type, 'time')){
                $field_list_controller_validation .= "'$field' => ['nullable', 'date'],\n";
                $vue_form_text .= "        <tr><td class=\"label\">" . ucwords(str_replace('_',' ',$field)) . ": </td><td><input class=\"text required " . $field . "\" name=\"$field\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"<?php if(\$boolEditMode) echo \$this->$field; ?>\"></td></tr>\n";
            }*/
            elseif (str_contains($fieldObj->Type, 'date')) {
                $field_list_controller_validation .= "            '$field' => ['nullable', 'date'],\n";
                $vue_form_text .= "      <FormsDateInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            } elseif (str_contains($fieldObj->Type, 'text')) {
                $field_list_controller_validation .= "            '$field' => ['nullable'],\n";
                $vue_form_text .= "      <FormsTextareaInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            } elseif (str_contains($fieldObj->Type, 'tinyint(1)')) {
                $field_list_controller_validation .= "            '$field' => ['nullable'],\n";
                $vue_form_text .= "      <FormsToggleInput v-model:checked=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
                $model_filter_text .= "        })->when(\$filters['$field'] ?? null, function (\$query, \$$field) {\n            \$query->where('$table.$field', \$$field === 'yes' ? 1 : 0);\n";
                $controller_filter_list .= ", '$field'";
                include('includes/VueReportFilter.php');
            } elseif (str_contains($fieldObj->Type, 'int')) {
                $field_list_controller_validation .= "            '$field' => ['nullable', 'integer'],\n";
                $vue_form_text .= "      <FormsNumberInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            } elseif (str_contains($fieldObj->Type, 'float') || str_contains($fieldObj->Type, 'decimal')) {
                $field_list_controller_validation .= "            '$field' => ['nullable', 'numeric'],\n";
                $vue_form_text .= "      <FormsNumberInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            }
            /*elseif($fieldObj->Type == 'timestamp'){
                //if the timestamp is auto-updating, don't allow adding or editing in form.  for now, also hide createtimestamp from form
                if($null != "NO" && $field != 'createtimestamp' && $field != 'modifytimestamp') $form_text .= "        <tr><td class=\"label\">" . ucwords(str_replace('_',' ',$field)) . ": </td><td><input id=\"datepicker\" class=\"text required " . $field . "\" name=\"$field\" type=\"text\" size=\"15\" maxlength=\"15\" value=\"<?php if(\$boolEditMode) echo \$this->$field; ?>\"></td></tr>\n";
                if($field != 'createtimestamp' && $field != 'modifytimestamp'){
                    $search_criteria_field .= "        <tr><td class=\"label\">" . ucwords(str_replace('_',' ',$field)) . ": </td><td><input id=\"datepicker\" class=\"text required " . $field . "\" name=\"$field\" type=\"text\" size=\"15\" maxlength=\"15\" value=\"<?php if(\$boolEditMode) echo \$this->$field; ?>\"></td></tr>\n";
                    if($field != 'id' && $field != 'createuser' && $field != 'modifyuser' && $field != 'createtimestamp' && $field != 'modifytimestamp') $report_line .=  "echo '<td>' . \$v['$field'] . '</td>';";
                }
            }*/
            else {
                $field_length = substr($fieldObj->Type, (strpos($fieldObj->Type, "(")+1), (strpos($fieldObj->Type, ")") - (strpos($fieldObj->Type, "(")+1)));
                ;
                $field_list_controller_validation .= "            '$field' => ['nullable', 'max:$field_length'],\n";
                $vue_form_text .= "      <FormsTextInput v-model=\"form.$field\" id=\"$field\" name=\"$field\" label=\"$field_label\" :error=\"errors.$field\" />\n";
            }
        } //while loop through each field
    }

    $model_snippets = "use Illuminate\Database\Eloquent\Builder;

    protected \$sortables = [$field_list_quoted_noids];
    protected \$searchColumns = [$field_list_quoted_noids];

    public function scopeFilter(Builder \$query, array \$filters) {
        \$query->when(\$filters['search'] ?? null, function (\$query, \$search) {
            \$query->eiSearch(\$this->searchColumns, \$search);
$model_filter_text
        })->when(\$filters['trashed'] ?? null, function (\$query, \$trashed) {
            if (\$trashed === 'with') {
                \$query->withTrashed();
            } elseif (\$trashed === 'only') {
                \$query->onlyTrashed();
            }
        });
    }

    /**
     * Scope a query to sort results.
     *
     * @param \Illuminate\Database\Eloquent\Builder \$query
     * @param \Illuminate\Http\Request \$request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder \$query, Array \$sort)
    {
        if (empty(\$sort)) {
            return;
        }

        foreach (\$sort as \$field => \$direction) {
            switch (\$field) {
                //make case statement for unique sorts
                case '{related-field}':
                    \$query->select('$table.*')
                        ->leftJoin('{related-table}', '$table.{fk}', '=', '{related-table}.id')
                        ->orderBy('{related-table}.{related-field}', \$direction);
                    break;
                default:
                    if (!in_array(\$field, \$this->sortables)) {
                        throw new \Exception('Sorting on the ' . \$field . ' column is not allowed.');
                    }
                    \$query->orderBy(\$field, \$direction);
                    break;
            }
        }
       return \$query;
    }

    public static function getValidationArray(): Array
    {
        return [
$field_list_controller_validation        ];
    }


";

    include('includes/Routes.php');

    if (!is_dir('generated/snippets')) {
        mkdir('generated/snippets', 0777, true);
    }
    $file = fopen('generated/snippets/' . $text['camelUpper']['plural'] . '.php', "w");
    fputs(
        $file,
        "/* FIND AND REPLACE
            {SECTION-camelPl}. : permissions */" . "\n\n" .
        "MODEL SNIPPETS:\n" . $model_snippets . "\n\n" .
        //"ROUTES:\n" . $routes . "\n\n" .
        //"PERMISSION SQL:\n" . $permissionsSql . "\n\n" .
        "QUOTED FIELD LIST:\n" . $field_list_quoted . "\n\n" .
        "UNQUOTED FIELD LIST:\n" . $field_list_unquoted . "\n\n"
    );
    fclose($file);

/******* Write vue list file **********************************************/
    include('includes/VueList.php');

/******* Write vue form file **********************************************/
    include('includes/VueForm.php');

/******* Write vue form file **********************************************/
    include('includes/VueInfoFile.php');

/******* Write controller file **********************************************/
    include('includes/Controller.php');

/******* Write controller file **********************************************/
    include('includes/ImportFile.php');
} //while (list($table) = mysql_fetch_row($arrTableResult))

// Write routes file
if (!is_dir('generated/routes')) {
    mkdir('generated/routes', 0777, true);
}
$file = fopen('generated/routes/web.php', "w");
fputs($file, $routes['base']);
fputs($file, $routes['admin'] . "\n    });\n");
fclose($file);

// Write permission file
$file = fopen('generated/permissions.sql', "w");
fputs($file, $permissionsSql);
fclose($file);

//Write menuData file
if (!is_dir('generated/resources/js/Data')) {
    mkdir('generated/resources/js/Data', 0777, true);
}
$file = fopen('generated/resources/js/Data/MainMenuData.json', "w");
fputs($file, $menuData . file_get_contents('includes/MainMenuData.json'));
fclose($file);

function getTextFormats($table)
{
    $table_upper = ucwords($table, "_");

    $table_words_lower_tmp = explode('_', $table);
    $table_words_lower['singular'] = $table_words_lower_tmp;
    $table_words_lower['plural'] = $table_words_lower_tmp;

    $table_words_upper_tmp = explode('_', $table_upper);
    $table_words_upper['singular'] = $table_words_upper_tmp;
    $table_words_upper['plural'] = $table_words_upper_tmp;

    $last = count($table_words_lower_tmp) - 1;

    //@todo: need to handle words that end with 's' in singular form
    $table_words_lower['plural'][$last] = str_ends_with($table_words_lower['plural'][$last], 's') ? $table_words_lower['plural'][$last] : Inflector::pluralize($table_words_lower['plural'][$last]);
    $table_words_lower['singular'][$last] = str_ends_with($table_words_lower['singular'][$last], 's') ? Inflector::singularize($table_words_lower['singular'][$last]) : $table_words_lower['singular'][$last];
    $table_words_upper['plural'][$last] = str_ends_with($table_words_upper['plural'][$last], 's') ? $table_words_upper['plural'][$last] : Inflector::pluralize($table_words_upper['plural'][$last]);
    $table_words_upper['singular'][$last] = str_ends_with($table_words_upper['singular'][$last], 's') ? Inflector::singularize($table_words_upper['singular'][$last]) : $table_words_upper['singular'][$last];


    $text['kabob']['plural'] = $table;
    $text['kabob']['singular'] = implode('_', $table_words_lower['singular']);
    $text['camel']['plural'] = lcfirst(implode('', $table_words_upper['plural']));
    $text['camel']['singular'] = lcfirst(implode('', $table_words_upper['singular']));
    $text['camelUpper']['plural'] = implode('', $table_words_upper['plural']);
    $text['camelUpper']['singular'] = implode('', $table_words_upper['singular']);
    $text['spacedUpper']['plural'] = implode(' ', $table_words_upper['plural']);
    $text['spacedUpper']['singular'] = implode(' ', $table_words_upper['singular']);

    return $text;
}
