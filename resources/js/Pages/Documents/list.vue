<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
        </template>

        <toast :toast="$page.toast"></toast>
        <jet-confirmation-modal :show="rowBeingDeleted" @close="rowBeingDeleted = null">
            <template #title>
                Delete Record
            </template>

            <template #content>
                Are you sure you would like to delete this record?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="rowBeingDeleted = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteRow" >
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <jet-button @click.native="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 float-right">Add New Document</jet-button>
                    
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">#</th>
                                <th class="px-4 py-2 w-20">ID.</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">File</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in data" :key="row.id">
                                <td class="border px-4 py-2">{{ index + 1 }}</td>
                                <td class="border px-4 py-2">{{ row.id }}</td>
                                <td class="border px-4 py-2">{{ row.title }}</td>
                                <td class="border px-4 py-2">{{ row.description }}</td>
                                <td class="border px-4 py-2">{{ row.file }}</td>
                                <td class="border px-4 py-2">
                                    <jet-button @click.native="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</jet-button>             
                                    <jet-danger-button @click.native="confirmDelete(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</jet-danger-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>

    import AppLayout from './../../Layouts/AppLayout';
    import Welcome from './../../Jetstream/Welcome';
    import Toast from './../../Components/Toast';
    import JetButton from '@/Jetstream/Button';
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        components: {
            AppLayout,
            Welcome,
            Toast,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
        },
        props: {
            data: Array,
            errors: Object
        },
        data() {
            return {
               rowBeingDeleted: null,              
            }
        },
        methods: {
            list: function() {
                this.$inertia
                .get(route("documents.index"), {
                    preserveScroll: true,
                }).then(response => {
                    this.data = response.data;
                });
            },
            create: function (data) {
               this.$inertia.get('/documents/create')
            },
            edit: function (data) {
               this.$inertia
                .get(route("documents.edit",data.id), {
                    preserveScroll: true,
                })
            },
            confirmDelete(row) {
                this.rowBeingDeleted = row
            },
            deleteRow: function (data) {
               this.$inertia
               .delete(route("documents.destroy",this.rowBeingDeleted.id), {
                    preserveScroll: true,
                });
            },
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
      
                this.$http.get('/documents?page=' + page)
                    .then(response => {
                        return response.json();
                    }).then(data => {
                        this.data = data;
                    });
            }
        }
    }
</script>