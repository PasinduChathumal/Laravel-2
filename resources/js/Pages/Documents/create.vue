<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="storeDocumentInformation">
                    <template #title>
                        Document Information
                    </template>

                    <template #description>
                        Enter your account's Document information.
                    </template>

                    <template #form>
                        <!-- File -->
                        <div class="col-span-6 sm:col-span-4">
                            <!-- Profile File File Input -->
                            <input type="file" class="hidden"
                                        ref="file"
                                        @change="updateFilePreview">

                            <jet-label for="file" value="File" />

                            <!-- Current Profile File -->
                            <div class="mt-2" v-show="! filePreview">
                                <img :src="form.file" alt="Document Preview" class="rounded-full h-20 w-20 object-cover">
                            </div>

                            <!-- New Profile File Preview -->
                            <div class="mt-2" v-show="filePreview">
                                <span class="block rounded-full w-20 h-20"
                                    :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + filePreview + '\');'">
                                </span>
                            </div>

                            <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewFile">
                                Select A New File
                            </jet-secondary-button>

                            <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deleteFile" v-if="form.file">
                                Remove File
                            </jet-secondary-button>

                            <jet-input-error :message="form.error('file')" class="mt-2" />
                        </div>

                        <!-- Title -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="title" value="Title" />
                            <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                            <jet-input-error :message="form.error('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="description" value="Description" />
                            <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                            <jet-input-error :message="form.error('description')" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import Toast from '@/Components/Toast'

export default {
  components: {
    AppLayout,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    Toast
  },

  data() {
    return {
      form: this.$inertia.form(
        {
          _method: "POST",
          title: this.title,
          description: this.description,
          file: this.file,
        },
        {
          bag: "storeDocumentInformation",
          resetOnSuccess: false,
        }
      ),

      filePreview: null,
    };
  },

  methods: {
    storeDocumentInformation() {
      if (this.$refs.file) {
        this.form.file = this.$refs.file.files[0];
      }

      this.form.post(route("documents.store"), {
        preserveScroll: true,
      });
    },

    selectNewFile() {
      this.$refs.file.click();
    },

    updateFilePreview() {
      const reader = new FileReader();

      reader.onload = (e) => {
        this.filePreview = e.target.result;
      };

      reader.readAsDataURL(this.$refs.file.files[0]);
    },

    deleteFile() {
      this.$inertia
        .delete(route("current-user-file.destroy"), {
          preserveScroll: true,
        })
        .then(() => {
          this.filePreview = null;
        });
    },
  },
};
</script>
