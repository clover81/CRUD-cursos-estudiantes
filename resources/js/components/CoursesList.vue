<template>
  <div>
    <div class="row">
      <input
        class="input"
        :value="filter"
        @input="$emit('update:filter', $event.target.value)"
        placeholder="Buscar curso..."
      />
    </div>

    <ul class="list">
      <li v-for="c in courses" :key="c.id" class="item">
        <div class="item-main">
          <strong>{{ c.name }}</strong>
          <span class="muted">({{ c.students_count ?? 0 }} students)</span>
          <span class="muted" v-if="c.description">— {{ c.description }}</span>
        </div>

        <div class="item-actions">
          <button class="btn" @click="$emit('edit', c)">Editar</button>
          <button class="btn danger" @click="$emit('remove', c)">Eliminar</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'CoursesList',
  props: {
    courses: { type: Array, required: true },
    filter: { type: String, required: true },
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
