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

watch(
  propsAlumnos,
  (nuevos) => {
    if (Array.isArray(nuevos) && nuevos.length > 0) {
      inicializarAsistencias()
    }
  },
  { immediate: true }
)

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
      class="col-12 col-md-6 col-lg-4 mb-4"
    >
      <div
        class="card alumno-card h-100 shadow-sm rounded-4 border-0"
        :class="{
          'asistencia-activa': asistencias[index],
          'retardo-activo': !asistencias[index] && retardos[index],
          'ausente': !asistencias[index] && !retardos[index]
        }"
      >
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="icon-circle fs-3 me-3">
              <i class="fa-solid fa-user" style="color: #6c757d;"></i>
            </div>
            <div>
              <h5 class="card-title mb-1">{{ alumno.nombre }} {{ alumno.apellidos }}</h5>
              <p class="card-text small text-muted mb-0">Grupo: {{ alumno.clave_grupo }}</p>
            </div>
          </div>

          <div class="d-flex flex-column align-items-end ms-3">
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                :id="'asistencia-' + index"
                :checked="asistencias[index]"
                @change="toggleAsistencia(index)"
                :class="{ 'opaco': retardos[index] }"
              />
              <label class="form-check-label small" :for="'asistencia-' + index">Asistencia</label>
            </div>

            <div class="form-check mt-2">
              <input
                class="form-check-input"
                type="checkbox"
                :id="'retardo-' + index"
                :checked="retardos[index]"
                @change="toggleRetardo(index)"
              />
              <label class="form-check-label small" :for="'retardo-' + index">Retardo</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.alumno-card {
  transition: all 0.3s ease;
  background-color: #fff;
  border-left: 5px solid transparent;
}

.alumno-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.icon-circle {
  height: 3.5rem;
  width: 3.5rem;
  border-radius: 50%;
  background-color: #f1f1f1;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.05);
}

/* Estados */
.asistencia-activa {
  border-left-color: #4EB294; /* antes: #67BA9F */
  background-color: #e9fcf4;  /* antes: #f0fdf9 */
}

.retardo-activo {
  border-left-color: #f4c842; /* antes: #f8db7c */
  background-color: #fff8d5;  /* antes: #fffbe7 */
}

.ausente {
  border-left-color: #f44350; /* antes: #f8787d */
  background-color: #ffecec;  /* antes: #fff5f5 */
}


.opaco {
  opacity: 0.6;
}
</style>
