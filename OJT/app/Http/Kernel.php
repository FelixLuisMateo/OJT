// Add to $routeMiddleware array
'admin' => \App\Http\Middleware\AdminMiddleware::class,
'coordinator' => \App\Http\Middleware\CoordinatorMiddleware::class,
'supervisor' => \App\Http\Middleware\SupervisorMiddleware::class, // create later
'student' => \App\Http\Middleware\StudentMiddleware::class, // create later
