<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BannerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\Auth\ClienteRegistroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;



use App\Http\Controllers\MaestroMaterialController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CompraMaterialController;
use App\Http\Controllers\InventarioMaterialController;
use App\Http\Controllers\AsignacionMaterialController;
use App\Http\Controllers\RecepcionPrendaController;
use App\Http\Controllers\InventarioPrendaController;
use App\Http\Controllers\ConfeccionistaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\AlmacenPrendaController;
use App\Http\Controllers\CatalogoPrendaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Ruta principal (muestra banners y mapa)
Route::get('/', [HomeController::class, 'index'])->name('home');


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Ruta para la vista de error no autorizado
Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
})->name('unauthorized');

// Rutas para administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Panel de Administrador
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});



//RUTAS FRONTEND

// Ruta para la página del login
// Route::get('/frontend/login', [FrontendController::class, 'login']);

// // Ruta para la página del registro
// Route::get('/frontend/registro', [FrontendController::class, 'registro']);

// Ruta para la página de la tienda
Route::get('/frontend/tienda', [FrontendController::class, 'tienda'])->name('frontend.tienda');



// Ruta para la página "Acerca de Nosotros"
Route::get('/frontend/acerca', [FrontendController::class, 'acerca'])->name('frontend.acerca');

// Ruta para la página del blog
Route::get('/frontend/blog', [FrontendController::class, 'blog'])->name('frontend.blog');

// Ruta para la página del contactos
Route::get('/frontend/contactanos', [FrontendController::class, 'contactanos'])->name('frontend.contactanos');
// Ruta para la página del try on
Route::get('/frontend/tryon', [FrontendController::class, 'tryon'])->name('frontend.tryon');





// Rutas para banners
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Mostrar lista de banners (solo usuarios autenticados)
    Route::get('banner.index', [BannerController::class, 'index'])->name('banner.index');

    // Mostrar formulario para crear un banner (solo usuarios autenticados)
    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');

    // Guardar un nuevo banner (solo usuarios autenticados)
    Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');

    // Mostrar formulario para editar un banner (solo usuarios autenticados)
    Route::get('/banner/{id}/edit', [BannerController::class, 'edit'])->name('banner.edit');

    // Actualizar un banner (solo usuarios autenticados)
    Route::put('/banner/{id}', [BannerController::class, 'update'])->name('banner.update');

    // Eliminar un banner (solo usuarios autenticados)
    Route::delete('/banner/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');
});


// Rutas para Departamentos (solo accesibles por administradores)
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Listar departamentos
    Route::get('/departamento', [DepartamentoController::class, 'index'])->name('departamento.index');

    // Mostrar formulario para crear un departamento
    Route::get('/departamento/create', [DepartamentoController::class, 'create'])->name('departamento.create');

    // Guardar un nuevo departamento
    Route::post('/departamento', [DepartamentoController::class, 'store'])->name('departamento.store');

    // Mostrar detalles de un departamento
    Route::get('/departamento/{id}', [DepartamentoController::class, 'show'])->name('departamento.show');

    // Mostrar formulario para editar un departamento
    Route::get('/departamento/{id}/edit', [DepartamentoController::class, 'edit'])->name('departamento.edit');

    // Actualizar un departamento
    Route::put('/departamento/{id}', [DepartamentoController::class, 'update'])->name('departamento.update');

    // Eliminar un departamento
    Route::delete('/departamento/{id}', [DepartamentoController::class, 'destroy'])->name('departamento.destroy');
});

// Rutas para Sucursales (solo accesibles por administradores)
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Listar sucursales
    Route::get('/sucursal', [SucursalController::class, 'index'])->name('sucursal.index');

    // Mostrar formulario para crear una sucursal
    Route::get('/sucursal/create', [SucursalController::class, 'create'])->name('sucursal.create');

    // Guardar una nueva sucursal
    Route::post('/sucursal', [SucursalController::class, 'store'])->name('sucursal.store');

    // Mostrar detalles de una sucursal
    Route::get('/sucursal/{id}', [SucursalController::class, 'show'])->name('sucursal.show');

    // Mostrar formulario para editar una sucursal
    Route::get('/sucursal/{id}/edit', [SucursalController::class, 'edit'])->name('sucursal.edit');

    // Actualizar una sucursal
    Route::put('/sucursal/{id}', [SucursalController::class, 'update'])->name('sucursal.update');

    // Eliminar una sucursal
    Route::delete('/sucursal/{id}', [SucursalController::class, 'destroy'])->name('sucursal.destroy');
});




// Rutas para usuarios (solo accesibles por administradores)
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});



// Rutas para Cliente (solo accesibles por administradores)
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Listar Cliente
    Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');

    // Mostrar formulario para crear un Cliente
    Route::get('/cliente/create', [ClienteController::class, 'create'])->name('cliente.create');

    // Guardar un nuevo Cliente
    Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');

    // Mostrar detalles de un Cliente
    Route::get('/cliente/{id}', [ClienteController::class, 'show'])->name('cliente.show');

    // Mostrar formulario para editar un Cliente
    Route::get('/cliente/{id}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');

    // Actualizar un Cliente
    Route::put('/cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');

    // Eliminar un Cliente
    Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
});




Route::middleware(['auth', 'role:Administrador'])->group(function () {
    // Vista Compra Material
    Route::get('/gestion_material', [MaestroMaterialController::class, 'index'])
         ->name('admin.gestion_material.index');
         
    
    // Materiales
    Route::prefix('materiales')->group(function () {
        Route::get('/create', [MaterialController::class, 'create'])->name('admin.gestion_material.modals.materiales.create');
        Route::post('/store', [MaterialController::class, 'store'])->name('admin.gestion_material.materiales.modals.store');
        Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('admin.gestion_material.materiales.modals.edit');
        Route::put('/update/{id}', [MaterialController::class, 'update'])->name('admin.gestion_material.materiales.modals.update');
        Route::delete('/destroy/{id}', [MaterialController::class, 'destroy'])->name('admin.gestion_material.materiales.modals.destroy');
    });

    // Proveedores
    Route::prefix('proveedores')->group(function () {
        Route::get('/create', [ProveedorController::class, 'create'])->name('admin.gestion_material.modals.proveedores.create');
        Route::post('/store', [ProveedorController::class, 'store'])->name('admin.gestion_material.modals.proveedores.store');
        Route::get('/edit/{id}', [ProveedorController::class, 'edit'])->name('admin.gestion_material.modals.proveedores.edit');
        Route::put('/update/{id}', [ProveedorController::class, 'update'])->name('admin.gestion_material.modals.proveedores.update');
        Route::delete('/destroy/{id}', [ProveedorController::class, 'destroy'])->name('admin.gestion_material.modals.proveedores.destroy');
    });

    // Almacenes
    Route::prefix('almacenes')->group(function () {
        Route::get('/create', [AlmacenController::class, 'create'])->name('admin.gestion_material.modals.almacenes.create');
        Route::post('/store', [AlmacenController::class, 'store'])->name('admin.gestion_material.modals.almacenes.store');
        Route::get('/edit/{id}', [AlmacenController::class, 'edit'])->name('admin.gestion_material.modals.almacenes.edit');
        Route::put('/update/{id}', [AlmacenController::class, 'update'])->name('admin.gestion_material.modals.almacenes.update');
        Route::delete('/destroy/{id}', [AlmacenController::class, 'destroy'])->name('admin.gestion_material.modals.almacenes.destroy');
    });
   
    // Rutas para Compras
    Route::prefix('compras')->group(function () {
        Route::post('/', [CompraMaterialController::class, 'store'])->name('compras.store');
        Route::post('/{id}/recibir', [CompraMaterialController::class, 'recibir'])->name('compras.recibir');
        Route::get('/{id}', [CompraMaterialController::class, 'show'])->name('compras.show');
        Route::get('/{id}/download', [CompraMaterialController::class, 'download'])->name('compras.download');
        Route::delete('/{id}', [CompraMaterialController::class, 'destroy'])->name('compras.destroy');
    });



    // Modulo INVENTARIO MATERIALES
    Route::get('/inventario_material', [InventarioMaterialController::class, 'index'])
        ->name('admin.inventario_material.index');
    // Configuración CEP
    Route::post('/{id}/configuracion-cep', [InventarioMaterialController::class, 'storeCEP'])
         ->name('admin.inventario_material.modals.configuracion_cep.store');
         
    Route::put('/{id}/configuracion-cep', [InventarioMaterialController::class, 'updateCEP'])
         ->name('admin.inventario_material.modals.configuracion_cep.update');



    // Modulo GEstion Asigancion y produccion
    Route::get('/gestion_produccion', [AsignacionMaterialController::class, 'index'])->name('admin.asignacion_material.index');

    Route::get('/create', [AsignacionMaterialController::class, 'create'])->name('admin.asignacion_material.create');
    Route::post('/store', [AsignacionMaterialController::class, 'store'])->name('admin.asignacion_material.store');
    Route::get('/edit/{id}', [AsignacionMaterialController::class, 'edit'])->name('admin.asignacion_material.edit');
    Route::put('/update/{id}', [AsignacionMaterialController::class, 'update'])->name('admin.asignacion_material.update');

    // Confeccionistas
    Route::post('/confeccionistas', [ConfeccionistaController::class, 'store'])->name('confeccionistas.store');
    Route::put('/confeccionistas/{id}', [ConfeccionistaController::class, 'update'])->name('confeccionistas.update');
    Route::delete('/confeccionistas/{id}', [ConfeccionistaController::class, 'destroy'])->name('confeccionistas.destroy');



    // Recepción de Prendas
    Route::prefix('recepcion-prendas')->group(function() {
        Route::get('/create/{asignacionId}', [RecepcionPrendaController::class, 'create'])->name('admin.recepcion_prendas.create');
        Route::post('/store', [RecepcionPrendaController::class, 'store'])->name('admin.recepcion_prendas.store');
        Route::get('/edit/{id}', [RecepcionPrendaController::class, 'edit'])->name('admin.recepcion_prendas.edit');
        Route::put('/update/{id}', [RecepcionPrendaController::class, 'update'])->name('admin.recepcion_prendas.update');
        Route::delete('/delete/{id}', [RecepcionPrendaController::class, 'destroy'])->name('admin.recepcion_prendas.destroy');

    });


    // GEstion de inventario de prendas
    Route::get('/inventario_prenda', [InventarioPrendaController::class, 'index'])
        ->name('admin.inventario_prenda.index');

        // Dentro de tu grupo de rutas admin
    Route::prefix('inventario-prendas')->name('admin.inventario_prenda.')->group(function() {
        Route::get('/', [InventarioPrendaController::class, 'index'])->name('index');
        Route::put('/{id}', [InventarioPrendaController::class, 'update'])->name('update');
        Route::post('/inventario-prendas/{id}/asignar-destino', [InventarioPrendaController::class, 'asignarDestino'])
     ->name('asignar-destino');
        
        // Rutas para categorías (modales)
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
        
        // Rutas para colecciones (modales)
        Route::post('/colecciones', [ColeccionController::class, 'store'])->name('colecciones.store');
        Route::put('/colecciones/{id}', [ColeccionController::class, 'update'])->name('colecciones.update');
    });



    Route::get('/almacen', [AlmacenPrendaController::class, 'index'])
        ->name('admin.almacen.index');
    
    Route::get('/catalogo', [CatalogoPrendaController::class, 'index'])
        ->name('admin.catalogo.index');
    // Movimientos de stock
    Route::post('/almacen/transferir', [AlmacenPrendaController::class, 'transferToCatalog'])
        ->name('admin.almacen.transferir');

    Route::post('/catalogo/devolver', [CatalogoPrendaController::class, 'returnToWarehouse'])
        ->name('admin.catalogo.devolver');

});






// Rutas para vendedor
Route::middleware(['auth', 'role:Vendedor'])->group(function () {
    // Panel de Vendedor
    Route::get('/vendedor/dashboard', function () {
        return view('vendedor.dashboard');
    })->name('vendedor.dashboard');
});



// Rutas para responasble
Route::middleware(['auth', 'role:Responsable'])->group(function () {
    // Panel de Responsable
    Route::get('/responsable/dashboard', function () {
        return view('responsable.dashboard');
    })->name('responsable.dashboard');
});













// Autenticación de clientes
Route::prefix('cliente')->group(function () {
    // Vistas
    Route::get('frontend/login', [FrontendController::class, 'login'])->name('cliente.login');
    Route::get('frontend/registro', [FrontendController::class, 'registro'])->name('cliente.registro');
    
    // Procesamiento
    Route::post('/login', [ClienteLoginController::class, 'autenticar'])->name('cliente.login.submit');
    Route::post('/registro', [ClienteRegistroController::class, 'registrar'])->name('cliente.registro.submit');
    Route::post('/logout', [ClienteLoginController::class, 'cerrarSesion'])->name('cliente.logout');
});

// Rutas protegidas para clientes
Route::prefix('cliente')->middleware(['auth:cliente'])->group(function () {
    Route::get('/cliente/inicio', [ClienteLoginController::class, 'index'])->name('cliente.inicio');
    // ... otras rutas protegidas para clientes ...
});

