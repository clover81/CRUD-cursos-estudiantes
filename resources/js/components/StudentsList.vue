<template>
  <div>
    <div class="row">
      <input
        class="input"
        :value="filter"
        @input="$emit('update:filter', $event.target.value)"
        placeholder="Buscar estudiante..."
      />

      <select
        class="input"
        style="max-width: 260px;"
        :value="courseFilter"
        @change="$emit('update:courseFilter', toNumberOrNull($event.target.value))"
      >
        <option value="">Todos los cursos</option>
        <option v-for="c in courses" :key="c.id" :value="c.id">
          {{ c.name }}
        </option>
      </select>
    </div>

    <ul class="list">
      <li v-for="s in students" :key="s.id" class="item">
        <div class="item-main">
          <strong>{{ s.name }}</strong>
          <span class="muted">— {{ s.email }}</span>
          <div class="muted" v-if="s.course">
            Curso: <strong>{{ s.course.name }}</strong>
          </div>
        </div>

        <div class="item-actions">
          <button class="btn" @click="$emit('edit', s)">Editar</button>
          <button class="btn danger" @click="$emit('remove', s.id)">Eliminar</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'StudentsList',
  props: {
    students: { type: Array, required: true },
    courses: { type: Array, required: true },
    filter: { type: String, required: true },
    courseFilter: { type: Number, default: null },
  },
  methods: {
    toNumberOrNull(value) {
      if (value === '' || value == null) return null;
      const n = Number(value);
      return Number.isNaN(n) ? null : n;
    },
  },
};
</script>

<style scoped>
.row { display: flex; gap: 10px; align-items: center; margin-bottom: 12px; }
.list { list-style: none; padding: 0; margin: 0; }
.item { display: flex; justify-content: space-between; gap: 10px; padding: 10px; border-top: 1px solid #eee; }
.item:first-child { border-top: 0; }
.item-main { flex: 1; }
.item-actions { display: flex; gap: 8px; }
.input { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; }
.btn { padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; background: #fff; }
.btn.danger { border-color: #d1242f; }
.muted { color: #666; margin-left: 6px; }
</style>
