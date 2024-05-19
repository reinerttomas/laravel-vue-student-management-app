<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';

defineProps({
  classes: {
    type: Object,
    required: true,
  },
  student: {
    type: Object,
    required: true,
  },
});

const student = usePage().props.student.data;
const sections = ref({});

const form = useForm({
  name: student.name,
  email: student.email,
  class_id: student.class.id,
  section_id: student.section.id,
});

const getSections = async (class_id) => {
  const { data } = await axios.get('/api/sections?class_id=' + class_id);
  sections.value = data;
};

const updateStudent = () => {
  form.put(route('students.update', student.id));
};

onMounted(() => {
  getSections(form.class_id);
});

watch(
  () => form.class_id,
  (newValue) => {
    getSections(newValue);
  }
);
</script>

<template>
  <Head title="Update Student" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
      >
        Update Student
      </h2>
    </template>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:col-span-12 lg:px-0">
          <form @submit.prevent="updateStudent()">
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
                      class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                      :class="{
                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500':
                          form.errors.name,
                      }"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
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
                      class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                      :class="{
                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500':
                          form.errors.email,
                      }"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
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
                      class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                      :class="{
                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500':
                          form.errors.class_id,
                      }"
                    >
                      <option value="">Select a Class</option>
                      <option
                        v-for="item in classes.data"
                        :key="item.id"
                        :value="item.id"
                      >
                        {{ item.name }}
                      </option>
                    </select>
                    <InputError :message="form.errors.class_id" class="mt-2" />
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
                      class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                      :class="{
                        'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500':
                          form.errors.section_id,
                      }"
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
                    <InputError
                      :message="form.errors.section_id"
                      class="mt-2"
                    />
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <Link
                  :href="route('students.index')"
                  class="mr-4 inline-flex items-center rounded-md border border-transparent bg-indigo-100 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
