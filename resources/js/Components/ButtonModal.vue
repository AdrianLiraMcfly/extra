<template>
    <button type="button" :class="'btn '+color" data-bs-toggle="modal" :data-bs-target="'#'+id_Modal">
      {{ boton }}
    </button>
    </template>
    
    <script>
    export default {
      props: {
        boton: String,
        id_Modal: String,
        color: String
      }
    }
    </script>