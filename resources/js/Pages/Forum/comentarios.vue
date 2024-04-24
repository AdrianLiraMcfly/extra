<template>
    <AuthenticatedLayout>
        <div v-if="$page.props.flash.message && showAlert" class="relative p-6 mb-4 text-green-700 bg-green-100 border-0 rounded-lg shadow-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="inline-block mr-5 align-middle">
                <i class="text-xl animate-bounce fas fa-bell"></i>
            </span>
            <span class="inline-block align-middle mr-8">
                <b class="font-semibold">¡Atención!</b> {{ $page.props.flash.message }}
            </span>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="closeAlert">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Cerrar</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"></path></svg>
            </button>
        </div>
        <div class="container mx-auto mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Comentarios del Tema: {{ tema.titulo }}</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Comentario</th>
                                        <th>Autor</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="comentario in comentarios" :key="comentario.id">
                                        <td>{{ comentario.comentario }}</td>
                                        <td>{{ comentario.user.name }}</td>
                                        <td>
                                            <button-modal id_Modal="modalEditarComentario" class="btn btn-warning" boton="Editar" @click="editComentario(comentario.id, comentario.comentario)"></button-modal>
                                            <button-modal id_Modal="modalEliminarComentario" class="btn btn-danger" boton="Eliminar" @click="obtenerComentario(comentario.id)"></button-modal>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="comentario" v-model="form.comentario">
                                <button class="btn btn-primary" @click="crearComentario">Crear</button>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <Modal id_modal="modalEditarComentario" titulo="Editar Comentario">
            <form @submit.prevent="editarComentario">
                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <input type="text" class="form-control" id="comentario" v-model="editform.comentario">
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Editar</button>
            </form>
        </Modal>

        <Modal id_modal="modalEliminarComentario" titulo="Eliminar Comentario">
            <p>¿Estas seguro de querer eliminar este comentario?</p>
            <button type="submit" class="btn btn-danger" @click="eliminarComentario" data-bs-dismiss="modal">Eliminar</button>
        </Modal>
    </AuthenticatedLayout>
</template>

<script>  
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import ButtonModal from '@/Components/ButtonModal.vue';
import { router } from '@inertiajs/vue3';

export default {
components: {
    AuthenticatedLayout,
    Modal,
    ButtonModal,
},
props: {
    tema: Object,
    comentarios: Array,
},
data() {
    return {
        form: {
            comentario: '',
        },
        editform: {
            comentario: '',
        },
        id: null,
        showAlert: true,
    }
},
methods: {
    editComentario(id, comentario) {
        this.id = id;
        this.editform.comentario = comentario;
    },
    obtenerComentario(id) {
        this.id = id;
    },
    crearComentario() {
        router.post(route('comentario.store', this.tema.id), this.form)
        this.form = {
            comentario: '',
        }
        this.showAlert = true;
        setTimeout(() => {
            this.showAlert = false;
        }, 3000);
    },
    editarComentario() {
        router.put(route('comentario.update', {tema: this.tema.id, comentario: this.id}), this.editform)
        this.editform.comentario = '';
        this.id= null;
        this.showAlert = true;
        setTimeout(() => {
            this.showAlert = false;
        }, 3000);
    },
    eliminarComentario() {
        router.delete(route('comentario.destroy', {tema: this.tema.id, comentario: this.id}))
        this.id = null;
        this.showAlert = true;
        setTimeout(() => {
            this.showAlert = false;
        }, 3000);
    },
}
}
</script>