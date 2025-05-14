<template>
  <div class="search-container mt-3 me-4">

    <div class="search-button">
        <i class="fa-solid fa-plus icono-buscar fs-2"></i>
    </div>

    <button class="search-input">
      Agregar alumno
    </button>
  </div>
</template>

<style scoped>
.icono-buscar {
  color: #ffffff;
}


.search-container {
  display: flex;
  align-items: center;
  width: fit-content;
  border: 1px solid #ccc;
  border-radius: 999px;
  overflow: hidden;
}

.search-input {
  padding: 8px 12px;
  border: none;
  outline: none;
  border-radius: 999px 0 0 999px;
}

.search-button {
  background-color: #12564D;
  cursor: pointer;
  border-left: 1px solid #ccc;
  border-radius: 999px 0 0 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 45px;
  height: 45px;
}

</style>
