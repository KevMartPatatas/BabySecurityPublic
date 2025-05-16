<script setup>
import { ref, watch, toRefs, defineExpose, computed } from 'vue'

const props = defineProps({
  alumnos: {
    type: Array,
    required: true
  },
  asistenciasPrevias: {
    type: Array,
    required: false,
    default: () => []
  }
})

const asistenciasPrevias = computed(() => props.asistenciasPrevias || [])
const { alumnos: propsAlumnos } = toRefs(props)
const emit = defineEmits(['updateCounts', 'enviarAsistencias'])

// estado reactivo (vacío inicialmente, se llenan después)
const asistencias = ref([])
const retardos = ref([])

function inicializarAsistencias() {
  asistencias.value = []
  retardos.value = []

  const alumnos = Array.isArray(propsAlumnos.value) ? propsAlumnos.value : []
  alumnos.forEach(alumno => {
    const previa = asistenciasPrevias.value.find(a => a.nocontrol === alumno.nocontrol)
    if (previa) {
      asistencias.value.push(previa.estado === 'presente')
      retardos.value.push(previa.estado === 'retardo')
    } else {
      // Si no hay registro previo, asigna ambos false
      asistencias.value.push(false)
      retardos.value.push(false)
    }
  })
}

function emitirAsistencias() {
  const alumnos = Array.isArray(propsAlumnos.value) ? propsAlumnos.value : []
  const datos = alumnos.map((alumno, i) => ({
    no_control: alumno.nocontrol,
    estado_asistencia: asistencias.value[i]
      ? 'presente'
      : (retardos.value[i] ? 'retardo' : 'ausente')
  }))
  console.log('Emitir asistencias con datos:', datos)
  emit('enviarAsistencias', datos)
}

// Contadores
function actualizarContadores() {
  const totalAlumnos = Array.isArray(propsAlumnos.value) ? propsAlumnos.value.length : 0
  const presentes = asistencias.value.filter(x => x).length
  const retardosC = retardos.value.filter(x => x).length
  const ausentes = totalAlumnos - presentes - retardosC

  emit('updateCounts', {
    presentes,
    ausentes,
    retardos: retardosC
  })
}

// Toggling de asistencia y retardo
function toggleAsistencia(i) {
  asistencias.value[i] = !asistencias.value[i]
  if (asistencias.value[i]) retardos.value[i] = false
  actualizarContadores()
}

function toggleRetardo(i) {
  retardos.value[i] = !retardos.value[i]
  if (retardos.value[i]) asistencias.value[i] = false
  actualizarContadores()
}

// Observa cuando alumnos estén disponibles y actualiza
watch(
  propsAlumnos,
  (nuevos) => {
    if (Array.isArray(nuevos) && nuevos.length > 0) {
      inicializarAsistencias()
    }
  },
  { immediate: true }
)

// Observa cambios en asistencias/retardos
watch(
  [asistencias, retardos],
  actualizarContadores,
  { deep: true, immediate: true }
)

defineExpose({ emitirAsistencias })
</script>



<template>
  <div class="alumnos-inscritos row">
    <div
      v-for="(alumno, index) in propsAlumnos"
      :key="index"
      class="col-4 mb-4"
    >
      <div
        class="card w-100 h-100 rounded-4"
        :class="{
          'asistencia-activa': asistencias[index],
          'retardo-activo': !asistencias[index] && retardos[index],
          'ausente': !asistencias[index] && !retardos[index]
        }"
      >
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="icon-circle fs-3">
              <i class="fa-solid fa-user" style="color: #ababab;"></i>
            </div>
            <div class="ms-3">
              <h5 class="card-title">
                {{ alumno.nombre }} {{ alumno.apellidos }}
              </h5>
              <p class="card-text" style="color: #333333; opacity: 70%;">
                Grupo: {{ alumno.clave_grupo }}
              </p>
            </div>
          </div>

          <div class="d-flex flex-column align-items-end">
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                :id="'asistencia-' + index"
                :checked="asistencias[index]"
                @change="toggleAsistencia(index)"
                :class="{ 'opaco': retardos[index] }"
              />
              <label class="form-check-label" :for="'asistencia-' + index">
                Asistencia
              </label>
            </div>

            <div class="form-check mt-2">
              <input
                class="form-check-input"
                type="checkbox"
                :id="'retardo-' + index"
                :checked="retardos[index]"
                @change="toggleRetardo(index)"
              />
              <label class="form-check-label" :for="'retardo-' + index">
                Retardo
              </label>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-body {
  display: flex;
  align-items: center;
}

.icon-circle {
  height: 4rem;
  width: 4rem;
  border-radius: 50%;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  margin-right: 10px;
}

.ms-3 {
  margin-left: 10px;
}

.flex-grow-1 {
  flex-grow: 1;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

/* Estados de asistencia */
.asistencia-activa {
  border: 2px solid #67BA9F;
}

.retardo-activo {
  border: 2px solid #F8DB7C;
}

.ausente {
  border: 2px solid #F8787D;
}

/* Opacidad si retardo está activo */
.opaco {
  opacity: 0.5;
}
</style>
