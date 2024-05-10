<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch } from 'vue';
import axios from 'axios';

defineProps({
  classes: {
    type: Object,
    required: true,
  },
});

const sections = ref({});

const form = useForm({
  name: '',
  email: '',
  class_id: '',
  section_id: '',
});

const getSections = async (classId) => {
  const { data } = await axios.get('/api/sections?class_id=' + classId);
  sections.value = data;
  form.section_id = '';
};

watch(
  () => form.class_id,
  (newValue) => {
    getSections(newValue);
  }
);
</script>

<template>
  <Head title="Create Student" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
      >
        Create Student
      </h2>
    </template>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:col-span-12 lg:px-0">
          <form>
            <div class="shadow sm:overflow-hidden sm:rounded-md">
              <div class="space-y-6 bg-white px-4 py-6 sm:p-6">
                <div>
                  <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Student Information
                  </h3>
                  <p class="mt-1 text-sm text-gray-500">
                    Use this form to create a new student.
                  </p>
                </div>

                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="name"
                      class="block text-sm font-medium text-gray-700"
                      >Name</label
                    >
                    <input
                      v-model="form.name"
                      type="text"
                      id="name"
                      class="@error('name') @enderror mt-1 block w-full rounded-md border border-gray-300 border-red-300 px-3 py-2 text-red-900 shadow-sm focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm"
                    />
                    <p class="mt-1 text-sm text-red-500">Error Message</p>
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="email"
                      class="block text-sm font-medium text-gray-700"
                      >Email Address</label
                    >
                    <input
                      v-model="form.email"
                      type="email"
                      id="email"
                      autocomplete="email"
                      class="@error('email') @enderror mt-1 block w-full rounded-md border border-gray-300 border-red-300 px-3 py-2 text-red-900 shadow-sm focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm"
                    />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="class_id"
                      class="block text-sm font-medium text-gray-700"
                      >Class</label
                    >
                    <select
                      v-model="form.class_id"
                      id="class_id"
                      class="@error('class_id') @enderror mt-1 block w-full rounded-md border border-gray-300 border-red-300 bg-white px-3 py-2 text-red-900 shadow-sm focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm"
                    >
                      <option value="">Select a Class</option>
                      <option
                        v-for="item in classes"
                        :key="item.id"
                        :value="item.id"
                      >
                        {{ item.name }}
                      </option>
                    </select>
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="section_id"
                      class="block text-sm font-medium text-gray-700"
                      >Section</label
                    >
                    <select
                      v-model="form.section_id"
                      id="section_id"
                      class="@error('section_id') @enderror mt-1 block w-full rounded-md border border-gray-300 border-red-300 bg-white px-3 py-2 text-red-900 shadow-sm focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm"
                    >
                      <option value="">Select a Section</option>
                      <option
                        v-for="section in sections"
                        key="section.id"
                        :value="section.id"
                      >
                        {{ section.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <a
                  href="#"
                  class="mr-4 inline-flex items-center rounded-md border border-transparent bg-indigo-100 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Cancel
                </a>
                <button
                  type="submit"
                  class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Save
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
