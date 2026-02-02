<template>
  <div class="form">
    <h3>{{ editing ? 'Editar curso' : 'Nuevo curso' }}</h3>

    <input v-model="localForm.name" class="input" placeholder="Name" />
    <textarea v-model="localForm.description" class="input" placeholder="Description (opcional)"></textarea>

    <div class="actions">
      <button class="btn primary" @click="$emit('save')" :disabled="saving">
        {{ saving ? 'Guardando...' : 'Guardar' }}
      </button>
      <button class="btn" @click="$emit('reset')">Nuevo</button>
    </div>

    <div class="error" v-if="error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  name: 'CoursesForm',
  props: {
    editing: Boolean,
    form: { type: Object, required: true },
    saving: Boolean,
    error: String,
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
textarea.input { min-height: 70px; resize: vertical; }
.actions { display: flex; gap: 8px; align-items: center; }
.btn { padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; background: #fff; }
.btn.primary { border-color: #2f6feb; }
.error { color: #d1242f; }
h3 { margin: 0; }
</style>
