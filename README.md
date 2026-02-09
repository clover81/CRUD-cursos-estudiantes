# CRUD Cursos y Estudiantes — Laravel + Vue

Aplicación web desarrollada con **Laravel (backend)** y **Vue.js (frontend)** que implementa un **CRUD completo de Cursos y Estudiantes**, con una relación **1:N** (un curso puede tener muchos estudiantes).

La aplicación sigue el mismo enfoque visto en clase: **Vue integrado dentro de Laravel**, consumiendo una **API REST** mediante `fetch`.

---

## Funcionalidades

### Cursos
- Crear cursos
- Listar cursos
- Editar cursos
- Eliminar cursos

### Estudiantes
- Crear estudiantes
- Listar estudiantes
- Editar estudiantes
- Eliminar estudiantes

### Relación 1:N
- Cada estudiante pertenece a un curso
- Selección de curso obligatoria al crear/editar estudiantes
- Eliminación en cascada de estudiantes al borrar un curso

---

## Estructura de la Base de Datos

### Tabla `courses`
| Campo | Tipo |
|------|------|
| id | integer (PK) |
| name | string |
| description | text |
| created_at / updated_at | timestamps |

### Tabla `students`
| Campo | Tipo |
|------|------|
| id | integer (PK) |
| name | string |
| email | string |
| course_id | foreign key → courses.id |
| created_at / updated_at | timestamps |

---

## Tecnologías usadas

- **Laravel 12**
- **Vue 3**
- **Vite**
- **Vue Router** (SPA)
- **MySQL**
- **Fetch API**
- **Laravel Sail (desarrollo local)**

---

## Arquitectura

- Backend: API RESTful con Laravel
- Frontend: SPA con Vue y Vue Router
- Integración full-stack (no aplicaciones separadas)
- Componentes Vue divididos por responsabilidad:
  - CoursesList / CoursesForm
  - StudentsList / StudentsForm

---

## Instalación en local (Laravel Sail)

### Clonar el repositorio
```bash
git clone https://github.com/TU_USUARIO/TU_REPO.git
cd TU_REPO
```

## Instalar dependencias PHP

`composer install`

## Levantar el entorno con Sail

`./vendor/bin/sail up -d`

## Configurar el entorno

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

## Migraciones y seeders

`./vendor/bin/sail artisan migrate:fresh --seed`

## Instalar dependencias frontend
```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

## Aplicación disponible en:

`http://localhost`

## Endpoints API

Cursos

GET /api/courses

POST /api/courses

PUT /api/courses/{id}

DELETE /api/courses/{id}

Estudiantes

GET /api/students

POST /api/students

PUT /api/students/{id}

DELETE /api/students/{id}

Enrutado en cliente (SPA)

La aplicación utiliza Vue Router:

/courses → gestión de cursos

/students → gestión de estudiantes

Laravel redirige todas las rutas (excepto /api) a la SPA.

## Build para producción
```bash
npm run build
```

Esto genera los archivos optimizados en la carpeta public/ para su despliegue en un servidor web.

## Despliegue

La aplicación está preparada para desplegarse en un servidor Linux (Apache + PHP + MySQL), ajustando:

.env

permisos de storage/ y bootstrap/cache

configuración del servidor apuntando a /public
