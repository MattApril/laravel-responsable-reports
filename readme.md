## Install

```composer require mattapril/laravel-responsable-reports```

#### For Lumen Projects

    $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
        return new \Illuminate\Routing\ResponseFactory(
            $app['Illuminate\Contracts\View\Factory'],
            $app['Illuminate\Routing\Redirector']
        );
    });

## Configuration
optional .env configuration:
    
    REPORT_PER_PAGE_KEY=per_page # define the input key that can be used to dynamically set the results per page for paginated responses
    REPORT_PER_PAGE_MAX=100 # sets the maximum number of results per page when using REPORT_PER_PAGE_KEY (default is 100)