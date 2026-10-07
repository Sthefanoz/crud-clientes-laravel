# Gestión de Clientes · CRUD + Login con Laravel (MVC)

Aplicación web desarrollada con **Laravel 13** que aplica el patrón **MVC (Modelo – Vista – Controlador)** para gestionar clientes mediante operaciones **CRUD** (Crear, Leer, Actualizar y Eliminar), protegidas por un sistema de **autenticación** con usuario y contraseña.

---

## Tabla de contenidos

- [Funcionalidades](#funcionalidades)
- [Tecnologías](#tecnologías)
- [Requisitos previos](#requisitos-previos)
- [Instalación](#instalación)
- [Uso](#uso)
- [Arquitectura MVC](#arquitectura-mvc)
- [Rutas de la aplicación](#rutas-de-la-aplicación)
- [Seguridad](#seguridad)
- [Pruebas automatizadas](#pruebas-automatizadas)
- [Estructura del proyecto](#estructura-del-proyecto)

---

## Funcionalidades

### Autenticación
- Inicio de sesión con correo electrónico y contraseña.
- Registro de nuevos usuarios (con confirmación de contraseña).
- Opción **"Recordarme"** para mantener la sesión abierta.
- Cierre de sesión.
- Las contraseñas se almacenan **cifradas** (nunca en texto plano).
- Las páginas del CRUD **no son accesibles sin iniciar sesión**: cualquier intento redirige al login.

### CRUD de clientes
- **Listar** clientes en una tabla con paginación (10 por página).
- **Buscar** clientes por nombre o correo.
- **Crear** clientes nuevos.
- **Ver** el detalle de un cliente.
- **Editar** los datos de un cliente.
- **Eliminar** clientes (con confirmación previa).
- Validación de formularios con mensajes de error en español.

---

## Tecnologías

| Tecnología | Uso |
|---|---|
| [PHP 8.3](https://www.php.net/) | Lenguaje del servidor |
| [Laravel 13](https://laravel.com/) | Framework MVC |
| [Eloquent ORM](https://laravel.com/docs/eloquent) | Acceso a la base de datos (Modelo) |
| [Blade](https://laravel.com/docs/blade) | Motor de plantillas (Vista) |
| [SQLite](https://www.sqlite.org/) | Base de datos |
| [Bootstrap 5](https://getbootstrap.com/) + Bootstrap Icons | Interfaz gráfica |
| [PHPUnit](https://phpunit.de/) | Pruebas automatizadas |

---

## Requisitos previos

- **PHP 8.3** o superior, con las extensiones `pdo_sqlite`, `sqlite3`, `mbstring`, `openssl`, `fileinfo` y `curl` habilitadas.
- **[Composer](https://getcomposer.org/)** 2.x
- **Git**

Comprueba que estén instalados:

```bash
php -v
composer -V
```

---

## Instalación

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/Sthefanoz/crud-clientes-laravel.git
   cd crud-clientes-laravel
   ```

2. **Instalar y configurar todo con un solo comando**

   ```bash
   composer setup
   ```

   Este comando:
   - instala las dependencias (`composer install`),
   - crea el archivo `.env` a partir de `.env.example`,
   - genera la clave de la aplicación (`APP_KEY`),
   - crea la base de datos SQLite (`database/database.sqlite`),
   - crea las tablas y carga los datos de prueba (`migrate --seed`).

   <details>
   <summary>Instalación paso a paso (alternativa)</summary>

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite        # en Windows PowerShell: New-Item database/database.sqlite
   php artisan migrate --seed
   ```
   </details>

3. **Levantar el servidor**

   ```bash
   php artisan serve
   ```

4. Abrir **http://127.0.0.1:8000** en el navegador.

---

## Uso

### Usuario de prueba

Al ejecutar los *seeders* se crea un usuario administrador y 15 clientes de ejemplo:

| Correo | Contraseña |
|---|---|
| `admin@example.com` | `admin123` |

También puedes crear tu propia cuenta desde **"¿No tienes cuenta? Regístrate"** en la pantalla de login.

### Flujo básico

1. Al abrir la aplicación se muestra el **login** (la sección de clientes está protegida).
2. Tras iniciar sesión se accede al **listado de clientes**.
3. Desde ahí se puede crear, ver, editar, eliminar y buscar clientes.
4. El botón **Salir** (barra superior) cierra la sesión.

### Reiniciar la base de datos

Para borrar todo y volver a cargar los datos de prueba:

```bash
php artisan migrate:fresh --seed
```

---

## Arquitectura MVC

La aplicación separa sus responsabilidades en tres capas:

```
          Navegador
              │  petición HTTP (ej. GET /clientes)
              ▼
   ┌──────────────────────┐
   │  Rutas (web.php)     │  decide qué controlador atiende la URL
   │  + middleware auth   │  y bloquea el acceso si no hay sesión
   └──────────┬───────────┘
              ▼
   ┌──────────────────────┐      ┌──────────────────────┐
   │  CONTROLADOR         │◄────►│  MODELO              │
   │  ClienteController   │      │  Cliente / User      │◄──► Base de datos
   │  AuthController      │      │  (Eloquent ORM)      │     (SQLite)
   └──────────┬───────────┘      └──────────────────────┘
              ▼
   ┌──────────────────────┐
   │  VISTA (Blade)       │  genera el HTML que ve el usuario
   │  clientes/*, auth/*  │
   └──────────────────────┘
```

| Capa | Archivos | Responsabilidad |
|---|---|---|
| **Modelo** | `app/Models/Cliente.php`, `app/Models/User.php` | Representan las tablas `clientes` y `users`, y realizan las consultas a la base de datos. |
| **Vista** | `resources/views/` | Plantillas Blade con el HTML de cada pantalla (listado, formularios, login, registro). |
| **Controlador** | `app/Http/Controllers/ClienteController.php`, `AuthController.php` | Reciben la petición, validan los datos, llaman al modelo y devuelven una vista o una redirección. |

Además:
- **Rutas** (`routes/web.php`): conectan cada URL con un método del controlador.
- **Form Requests** (`app/Http/Requests/`): contienen las reglas de validación del formulario de clientes.
- **Migraciones** (`database/migrations/`): definen la estructura de las tablas en código.

---

## Rutas de la aplicación

### Públicas

| Método | URL | Acción |
|---|---|---|
| GET | `/login` | Formulario de inicio de sesión |
| POST | `/login` | Verificar credenciales e iniciar sesión |
| GET | `/register` | Formulario de registro |
| POST | `/register` | Crear la cuenta e iniciar sesión |

### Protegidas (requieren iniciar sesión)

| Método | URL | Acción | Operación CRUD |
|---|---|---|---|
| GET | `/clientes` | Listado y búsqueda | **R**ead |
| GET | `/clientes/create` | Formulario de nuevo cliente | **C**reate |
| POST | `/clientes` | Guardar cliente | **C**reate |
| GET | `/clientes/{id}` | Detalle del cliente | **R**ead |
| GET | `/clientes/{id}/edit` | Formulario de edición | **U**pdate |
| PUT | `/clientes/{id}` | Guardar cambios | **U**pdate |
| DELETE | `/clientes/{id}` | Eliminar cliente | **D**elete |
| POST | `/logout` | Cerrar sesión | — |

Si se intenta abrir cualquier ruta protegida sin haber iniciado sesión, el middleware `auth` redirige automáticamente a `/login`.

Para ver todas las rutas registradas:

```bash
php artisan route:list
```

---

## Seguridad

| Medida | Descripción |
|---|---|
| **Contraseñas cifradas con bcrypt** | Las contraseñas se guardan como *hash* irreversible usando **bcrypt** (cast `'password' => 'hashed'` del modelo `User`). Se eligió bcrypt en lugar de **md5** porque md5 es muy rápido de calcular y ya no se considera seguro para contraseñas, mientras que bcrypt añade una *sal* (*salt*) aleatoria y un costo de cómputo que dificulta los ataques de fuerza bruta. |
| **Rutas protegidas** | Middleware `auth`: sin sesión no se puede acceder al CRUD. |
| **Protección CSRF** | Todos los formularios incluyen `@csrf`; Laravel rechaza peticiones sin un token válido. |
| **Límite de intentos** | Máximo 5 intentos de login por minuto (`throttle:5,1`) para frenar ataques de fuerza bruta. |
| **Regeneración de sesión** | Al iniciar sesión se genera un nuevo ID de sesión (previene *session fixation*). |
| **Protección XSS** | Blade escapa automáticamente todo lo que se imprime con `{{ }}`. |
| **Asignación masiva controlada** | Solo los campos de `$fillable` pueden guardarse desde un formulario. |

Ejemplo de cómo se ve una contraseña almacenada en la tabla `users`:

```
$2y$12$Qm3rUq0bH1j8... (60 caracteres, distinto cada vez aunque la contraseña sea la misma)
```

---

## Pruebas automatizadas

El proyecto incluye pruebas que verifican el login, el registro, la protección de rutas y cada operación del CRUD:

```bash
php artisan test
```

| Archivo | Qué prueba |
|---|---|
| `tests/Feature/LoginTest.php` | Redirección al login sin sesión, login correcto e incorrecto, registro, validaciones y cierre de sesión. |
| `tests/Feature/ClienteCrudTest.php` | Listar, buscar, crear, validar, editar y eliminar clientes. |

---

## Estructura del proyecto

Solo se muestran los archivos propios de la aplicación (el resto es la estructura estándar de Laravel):

```
clientes-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login, registro y logout
│   │   │   └── ClienteController.php     # Operaciones CRUD
│   │   └── Requests/
│   │       ├── StoreClienteRequest.php   # Validación al crear
│   │       └── UpdateClienteRequest.php  # Validación al editar
│   └── Models/
│       ├── Cliente.php                   # Modelo de clientes
│       └── User.php                      # Modelo de usuarios
├── database/
│   ├── factories/ClienteFactory.php      # Genera clientes de prueba
│   ├── migrations/                       # Estructura de las tablas
│   └── seeders/                          # Datos iniciales (admin + 15 clientes)
├── resources/views/
│   ├── layouts/app.blade.php             # Plantilla base (barra superior y alertas)
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   └── clientes/
│       ├── index.blade.php               # Listado
│       ├── create.blade.php              # Nuevo cliente
│       ├── edit.blade.php                # Editar cliente
│       ├── show.blade.php                # Detalle
│       └── _form.blade.php               # Formulario compartido
├── routes/web.php                        # Rutas públicas y protegidas
└── tests/Feature/                        # Pruebas automatizadas
```

---

## Autor

**Sthefanoz**
