<template>
  <section class="box">
    <h2>Students</h2>

    <StudentsForm
      :editing="editing"
      :form="form"
      :saving="saving"
      :error="error"
      :fieldErrors="fieldErrors"
      :courses="courses"
      @save="save"
      @reset="resetForm"
    />

    <StudentsList
      :students="filteredStudents"
      :courses="courses"
      :filter="filter"
      :courseFilter="courseFilter"
      @update:filter="filter = $event"
      @update:courseFilter="courseFilter = $event"
      @edit="edit"
      @remove="remove"
    />
  </section>
</template>

<script>
import StudentsList from './StudentsList.vue';
import StudentsForm from './StudentsForm.vue';

export default {
  name: 'Students',
  components: { StudentsList, StudentsForm },
  data() {
    return {
      apiStudents: '/api/students',
      apiCourses: '/api/courses',

      students: [],
      courses: [],

      filter: '',
      courseFilter: null,

      editing: false,
      saving: false,
      error: '',
      fieldErrors: {},
      form: { id: null, name: '', email: '', course_id: null },
    };
  },
  computed: {
    filteredStudents() {
      const q = this.filter.toLowerCase().trim();
      let list = this.students;

      if (this.courseFilter != null) {
        list = list.filter(s => (s.course_id ?? s.course?.id) === this.courseFilter);
      }

      if (!q) return list;

      return list.filter(s =>
        (s.name || '').toLowerCase().includes(q) ||
        (s.email || '').toLowerCase().includes(q) ||
        (s.course?.name || '').toLowerCase().includes(q)
      );
    },
  },
  methods: {
    async loadCourses() {
      const res = await fetch(this.apiCourses, { headers: { Accept: 'application/json' } });
      if (!res.ok) throw new Error('No se pudieron cargar los cursos');
      this.courses = await res.json();
    },
    async loadStudents() {
      const res = await fetch(this.apiStudents, { headers: { Accept: 'application/json' } });
      if (!res.ok) throw new Error('No se pudieron cargar los estudiantes');
      this.students = await res.json();
    },
    async loadAll() {
      this.error = '';
      try {
        await Promise.all([this.loadCourses(), this.loadStudents()]);
      } catch (e) {
        this.error = e.message || 'Error cargando datos';
      }
    },

    onCoursesUpdated: async function () {
      // si cambian cursos (crear/editar/borrar), refrescamos ambos
      await this.loadCourses();
      await this.loadStudents();

      // si el filtro apunta a un curso borrado, lo quitamos
      if (this.courseFilter != null && !this.courses.some(c => c.id === this.courseFilter)) {
        this.courseFilter = null;
      }

      // si estabas editando un student y su curso desaparece, lo reseteamos
      if (this.editing && this.form.course_id != null && !this.courses.some(c => c.id === this.form.course_id)) {
        this.form.course_id = null;
      }
    },

    edit(student) {
      this.form = {
        id: student.id,
        name: student.name ?? '',
        email: student.email ?? '',
        course_id: student.course_id ?? student.course?.id ?? null,
      };
      this.editing = true;
      this.error = '';
    },
    resetForm() {
      this.form = { id: null, name: '', email: '', course_id: null };
      this.editing = false;
      this.error = '';
    },

    async save() {
      this.error = '';
      this.fieldErrors = {};
      if (!this.form.name.trim()) return (this.error = 'El nombre es obligatorio');
      if (!this.form.email.trim()) return (this.error = 'El email es obligatorio');
      if (this.form.course_id == null) return (this.error = 'Debes seleccionar un curso');

      this.saving = true;
      try {
        const isEdit = this.editing && this.form.id != null;
        const url = isEdit ? `${this.apiStudents}/${this.form.id}` : this.apiStudents;

        const res = await fetch(url, {
          method: isEdit ? 'PUT' : 'POST',
          headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
          body: JSON.stringify({
            name: this.form.name,
            email: this.form.email,
            course_id: this.form.course_id,
          }),
        });

        if (!res.ok) {
          if (res.status === 422) {
          const data = await res.json();
          this.fieldErrors = data.errors || {};
          return;
        }

        const data = await res.json().catch(() => null);
        throw new Error(data?.message || 'Error guardando el estudiante');
    }

        this.resetForm();
        await this.loadStudents();
      } catch (e) {
        this.error = e.message || 'Error guardando estudiante';
      } finally {
        this.saving = false;
      }
    },

    async remove(id) {
      this.error = '';
      if (!confirm('¿Eliminar este estudiante?')) return;

      try {
        const res = await fetch(`${this.apiStudents}/${id}`, {
          method: 'DELETE',
          headers: { Accept: 'application/json' },
        });
        if (!res.ok && res.status !== 204) throw new Error('Error eliminando el estudiante');
        await this.loadStudents();
        if (this.form.id === id) this.resetForm();
      } catch (e) {
        this.error = e.message || 'Error eliminando estudiante';
      }
    },
  },
  mounted() {
    window.addEventListener('courses-updated', this.onCoursesUpdated);
    this.loadAll();
  },
  unmounted() {
    window.removeEventListener('courses-updated', this.onCoursesUpdated);
  },
};
</script>

<style scoped>
.box { border: 1px solid #ddd; border-radius: 10px; padding: 16px; }
h2 { margin: 0 0 12px 0; }
</style>
