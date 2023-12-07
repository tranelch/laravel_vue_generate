    'providers' => [
        /*
         * Package Service Providers...
         */
        \Junges\ACL\Providers\ACLServiceProvider::class,
        \Junges\ACL\Providers\ACLAuthServiceProvider::class,
        \Junges\ACL\Providers\ACLEventsServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Lab404\Impersonate\ImpersonateServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
    ],
