<?php
    $routes['base'] .= "\n\n    Route::prefix('" . $text['kabob']['plural'] . "')->group(function () {
        Route::get('/export', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'export'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
        Route::post('/import', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'import'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
        Route::get('/', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'index'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
        Route::get('/create', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'create'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
        Route::get('/{" . $text['kabob']['singular'] . "}/show', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'show'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
        Route::get('/{" . $text['kabob']['singular'] . "}/edit', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'edit'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".edit');
        Route::post('/', [\App\Http\Controllers{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'store'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
        Route::put('/{" . $text['kabob']['singular'] . "}', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'update'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".edit');
        Route::get('/{" . $text['kabob']['singular'] . "}/restore', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'restore'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".restore');
        Route::delete('/{" . $text['kabob']['singular'] . "}/remove', [\App\Http\Controllers\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'remove'])->middleware('permissions:{SECTION-camelPl}." . $text['camel']['plural'] . ".remove');
    });";
    $routes['admin'] .= "\n\n        Route::prefix('" . $text['kabob']['plural'] . "')->group(function () {
            Route::get('/export', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'export'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
            Route::post('/import', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'import'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
            Route::get('/', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'index'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
            Route::get('/create', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'create'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
            Route::get('/{" . $text['kabob']['singular'] . "}/show', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'show'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".view');
            Route::get('/{" . $text['kabob']['singular'] . "}/edit', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'edit'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".edit');
            Route::post('/', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'store'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".create');
            Route::put('/{" . $text['kabob']['singular'] . "}', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'update'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".edit');
            Route::get('/{" . $text['kabob']['singular'] . "}/restore', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'restore'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".restore');
            Route::delete('/{" . $text['kabob']['singular'] . "}/remove', [\App\Http\Controllers\Admin\{SECTION-camelUp}\\" . $text['camelUpper']['plural'] . "Controller::class, 'remove'])->middleware('permissions:admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".remove');
        });";


$permissionsSql .= "
    INSERT INTO `acl_permissions` (`id`, `name`, `slug`, `description`, `deleted_at`, `created_at`, `updated_at`)
    VALUES
        (NULL, 'Create " . $text['spacedUpper']['plural'] . "', '{SECTION-camelPl}." . $text['camel']['plural'] . ".create', 'Create " . $text['spacedUpper']['plural'] . "', NULL, NULL, NULL),
        (NULL, 'Edit " . $text['spacedUpper']['plural'] . "', '{SECTION-camelPl}." . $text['camel']['plural'] . ".edit', 'Edit " . $text['spacedUpper']['plural'] . "', NULL, NULL, NULL),
        (NULL, 'View " . $text['spacedUpper']['plural'] . "', '{SECTION-camelPl}." . $text['camel']['plural'] . ".view', 'View " . $text['spacedUpper']['plural'] . "', NULL, NULL, NULL),
        (NULL, 'Remove " . $text['spacedUpper']['plural'] . "', '{SECTION-camelPl}." . $text['camel']['plural'] . ".remove', 'Remove " . $text['spacedUpper']['plural'] . "', NULL, NULL, NULL),
        (NULL, 'Restore " . $text['spacedUpper']['plural'] . "', '{SECTION-camelPl}." . $text['camel']['plural'] . ".restore', 'Restore " . $text['spacedUpper']['plural'] . "', NULL, NULL, NULL);

    INSERT INTO acl_group_has_permissions (SELECT {group_id}, pm.id  FROM acl_permissions pm WHERE pm.slug LIKE '{SECTION-camelPl}." . $text['camel']['plural'] . ".%' AND NOT EXISTS(SELECT * FROM acl_group_has_permissions WHERE group_id = {group_id} AND permission_id = pm.id ));
";

$menuData .= '
    {
        "title": "' . $text['spacedUpper']['plural'] . '",
        "route": "/{SECTION-kabob}/' . $text['kabob']['plural'] . '",
        "icon": "",
        "class": "' . $text['kabob']['plural'] . '",
        "permissions": ["{SECTION-camelPl}.' . $text['camel']['plural'] . '.view"],
        "children": [],
        "attributes": [],
    },
';

//Admin
/*$permissionsSql .= "
    INSERT INTO `acl_permissions` (`id`, `name`, `slug`, `description`, `deleted_at`, `created_at`, `updated_at`)
    VALUES
        (NULL, 'Admin Create " . $text['spacedUpper']['plural'] . "', 'admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".create', 'Create My " . $text['spacedUpper']['plural'] . " in Admin', NULL, NULL, NULL),
        (NULL, 'Admin Edit " . $text['spacedUpper']['plural'] . "', 'admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".edit', 'Edit My " . $text['spacedUpper']['plural'] . " in Admin', NULL, NULL, NULL),
        (NULL, 'Admin Remove " . $text['spacedUpper']['plural'] . "', 'admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".remove', 'Remove My " . $text['spacedUpper']['plural'] . " in Admin', NULL, NULL, NULL),
        (NULL, 'Admin Restore " . $text['spacedUpper']['plural'] . "', 'admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".restore', 'Restore My " . $text['spacedUpper']['plural'] . " in Admin', NULL, NULL, NULL),
        (NULL, 'Admin View " . $text['spacedUpper']['plural'] . "', 'admin.{SECTION-camelPl}." . $text['camel']['plural'] . ".view', 'View My " . $text['spacedUpper']['plural'] . " in Admin', NULL, NULL, NULL);

    INSERT INTO acl_group_has_permissions (SELECT 1, pm.id  FROM acl_permissions pm WHERE NOT EXISTS(SELECT * FROM acl_group_has_permissions WHERE group_id = 1 AND permission_id = pm.id AND pm.slug LIKE 'admin.%' ) INSERT INTO acl_group_has_permissions (SELECT 1, pm.id  FROM acl_permissions pm WHERE NOT EXISTS(SELECT * FROM acl_group_has_permissions WHERE group_id = 1 AND permission_id = pm.id AND pm.slug LIKE 'admin.%' ) AND pm.slug LIKE 'admin.%'););
";*/
