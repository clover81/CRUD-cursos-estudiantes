<template>
  <div class="form">
    <h3>{{ editing ? 'Editar estudiante' : 'Nuevo estudiante' }}</h3>

    <input v-model="localForm.name" class="input" placeholder="Name" />
    <input v-model="localForm.email" class="input" placeholder="Email" />

    <select v-model.number="localForm.course_id" class="input" :disabled="courses.length === 0">
      <option :value="null" disabled>Selecciona un curso...</option>
      <option v-for="c in courses" :key="c.id" :value="c.id">
        {{ c.name }}
      </option>
    </select>

    <div class="actions">
      <button class="btn primary" @click="$emit('save')" :disabled="saving || courses.length === 0">
        {{ saving ? 'Guardando...' : 'Guardar' }}
      </button>
      <button class="btn" @click="$emit('reset')">Nuevo</button>
    </div>

    <div class="error" v-if="error">{{ error }}</div>
    <div class="muted" v-if="courses.length === 0">
      (Crea al menos un curso antes de añadir estudiantes)
    </div>
  </div>
</template>

<script>
export default {
  name: 'StudentsForm',
  props: {
    editing: Boolean,
    form: { type: Object, required: true },
    saving: Boolean,
    error: String,
    courses: { type: Array, required: true },
  },
  computed: {
    localForm: {
      get() { return this.form; },
      set() {},
    },
  },
};
</script>

<style scoped>
.form { display: grid; gap: 10px; margin-bottom: 14px; }
.input { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; }
.actions { display: flex; gap: 8px; align-items: center; }
.btn { padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; background: #fff; }
.btn.primary { border-color: #2f6feb; }
.error { color: #d1242f; }
.muted { color: #666; }
h3 { margin: 0; }
</style>
