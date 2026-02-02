<template>
  <div class="container">
    <header class="header">
      <h1 class="title">CRUD Cursos y Estudiantes</h1>

      <nav class="nav">
        <RouterLink class="link" active-class="active" to="/courses">Courses</RouterLink>
        <RouterLink class="link" active-class="active" to="/students">Students</RouterLink>
      </nav>
    </header>

    <main class="main">
      <RouterView />
    </main>
  </div>
</template>

<script>
export default { name: 'App' };
</script>

<style scoped>
.container { max-width: 900px; margin: 40px auto; font-family: sans-serif; padding: 0 12px; }
.header { display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px; }
.title { margin: 0; font-size: 28px; font-weight: 800; }
.nav { display: flex; gap: 10px; }
.link { padding: 8px 12px; border: 1px solid #ccc; border-radius: 10px; text-decoration: none; color: inherit; }
.active { border-color: #2f6feb; font-weight: 700; }
.main { margin-top: 8px; }
</style>
