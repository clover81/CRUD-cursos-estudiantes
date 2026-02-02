<template>
  <section class="box">
    <h2>Courses</h2>

    <CoursesForm
      :editing="editing"
      :form="form"
      :saving="saving"
      :error="error"
      @save="save"
      @reset="resetForm"
    />

    <CoursesList
      :courses="filteredCourses"
      :filter="filter"
      @update:filter="filter = $event"
      @edit="edit"
      @remove="remove"
    />
  </section>
</template>

<script>
import CoursesList from './CoursesList.vue';
import CoursesForm from './CoursesForm.vue';

export default {
  name: 'Courses',
  components: { CoursesList, CoursesForm },
  data() {
    return {
      apiBase: '/api/courses',
      courses: [],
      filter: '',
      editing: false,
      saving: false,
      error: '',
      form: { id: null, name: '', description: '' },
    };
  },
  computed: {
    filteredCourses() {
      const q = this.filter.toLowerCase().trim();
      if (!q) return this.courses;
      return this.courses.filter(c =>
        (c.name || '').toLowerCase().includes(q) ||
        (c.description || '').toLowerCase().includes(q)
      );
    },
  },
  methods: {
    async load() {
      this.error = '';
      const res = await fetch(this.apiBase, { headers: { Accept: 'application/json' } });
      if (!res.ok) throw new Error('No se pudieron cargar los cursos');
      this.courses = await res.json();
    },
    edit(course) {
      this.form = { id: course.id, name: course.name ?? '', description: course.description ?? '' };
      this.editing = true;
      this.error = '';
    },
    resetForm() {
      this.form = { id: null, name: '', description: '' };
      this.editing = false;
      this.error = '';
    },
    async save() {
      this.error = '';
      if (!this.form.name.trim()) return (this.error = 'El nombre es obligatorio');

      this.saving = true;
      try {
        const isEdit = this.editing && this.form.id != null;
        const url = isEdit ? `${this.apiBase}/${this.form.id}` : this.apiBase;

        const res = await fetch(url, {
          method: isEdit ? 'PUT' : 'POST',
          headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
          body: JSON.stringify({
            name: this.form.name,
            description: this.form.description || null,
          }),
        });

        if (!res.ok) {
          const data = await res.json().catch(() => null);
          throw new Error(data?.message || 'Error guardando el curso');
        }

        this.resetForm();
        await this.load();
        window.dispatchEvent(new Event('courses-updated'));
      } catch (e) {
        this.error = e.message || 'Error guardando curso';
      } finally {
        this.saving = false;
      }
    },
    async remove(id) {
      this.error = '';
      if (!confirm('¿Eliminar este curso? (Se eliminarán sus estudiantes por cascade)')) return;

      try {
        const res = await fetch(`${this.apiBase}/${id}`, {
          method: 'DELETE',
          headers: { Accept: 'application/json' },
        });
        if (!res.ok && res.status !== 204) throw new Error('Error eliminando el curso');

        await this.load();
        window.dispatchEvent(new Event('courses-updated'));
        if (this.form.id === id) this.resetForm();
      } catch (e) {
        this.error = e.message || 'Error eliminando curso';
      }
    },
  },
  async mounted() {
    try {
      await this.load();
    } catch (e) {
      this.error = e.message || 'Error cargando cursos';
    }
  },
};
</script>

<style scoped>
.box { border: 1px solid #ddd; border-radius: 10px; padding: 16px; margin-bottom: 20px; }
h2 { margin: 0 0 12px 0; }
</style>
