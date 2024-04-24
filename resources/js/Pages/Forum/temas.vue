<template>
        <AuthenticatedLayout>
            <div v-if="$page.props.flash.message" class="relative p-6 mb-4 text-green-700 bg-green-100 border-0 rounded-lg shadow-lg dark:bg-green-200 dark:text-green-800" role="alert">
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
                            <div class="card-header">Temas del Canal: {{ canal.nombre }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    
    <script>  
    import ButtonModal from '@/Components/ButtonModal.vue';
    import Modal from '@/Components/Modal.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router } from '@inertiajs/vue3';
    import axios from 'axios';
    
    export default {
    components: {
        ButtonModal,
        Modal,
        AuthenticatedLayout
    },
    props: {
        canal: Object,
        temas: Array,
    },
    data() {
        return {
            form: {
                titulo: '',
            },
        }
    },
 
    }
    </script>