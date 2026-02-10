# CRUD Cursos y Estudiantes — Laravel + Vue

Aplicación web desarrollada con **Laravel (backend)** y **Vue.js (frontend)** que implementa un **CRUD completo de Cursos y Estudiantes**, con una relación **1:N** (un curso puede tener muchos estudiantes).

La aplicación sigue el mismo enfoque visto en clase: **Vue integrado dentro de Laravel**, consumiendo una **API REST** mediante `fetch`.

---

## Funcionalidades

### Cursos
- Crear cursos
- Listar cursos
- Editar cursos
- Eliminar cursos (solo si no tienen estudiantes asociados)

### Estudiantes
- Crear estudiantes
- Listar estudiantes
- Editar estudiantes
- Eliminar estudiantes

### Relación 1:N y reglas de integridad

- Cada estudiante pertenece obligatoriamente a un curso
- Selección de curso obligatoria al crear/editar estudiantes
- No se permite eliminar un curso que tenga estudiantes asociados
- La integridad referencial está garantizada tanto en:
- Base de datos (restricción de clave foránea)
- Backend (validación en la API)
- Frontend (bloqueo y mensaje informativo al usuario)
- Este enfoque evita la pérdida accidental de datos y reproduce el comportamiento habitual en aplicaciones reales.

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
| course_id | foreign key → courses.id (RESTRICT) |
| created_at / updated_at | timestamps |

---

## Tecnologías usadas

- **Laravel 12**
- **Vue 3**
- **Vite**
- **Vue Router** (SPA)
- **MySQL**
- **Fetch API**

---

## Arquitectura

- Backend: API RESTful con Laravel
- Frontend: SPA con Vue y Vue Router
- Integración full-stack (no aplicaciones separadas)
- Componentes Vue divididos por responsabilidad:
  - CoursesList / CoursesForm
  - StudentsList / StudentsForm

---

## Instalación en local

### Clonar el repositorio
```bash
git clone https://github.com/clover81/CRUD-cursos-estudiantes.git
cd CRUD-cursos-estudiantes
```

## Instalar dependencias backend

`composer install`

## Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

## Migraciones y seeders

`php artisan migrate:fresh --seed`

## Instalación frontend (Vite)
```bash
npm install
npm run dev
```

## En otra terminal

`php artisan serve`

## Aplicación disponible en:

`http://127.0.0.1:8000`

## Endpoints API

Cursos

GET /api/courses

POST /api/courses

PUT /api/courses/{id}

DELETE /api/courses/{id}
 - Devuelve 409 Conflict si el curso tiene estudiantes asociados

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

## Nota técnica

El borrado de cursos está protegido para evitar pérdidas de datos, aplicando buenas prácticas de integridad referencial y control de errores en todas las capas de la aplicación.
