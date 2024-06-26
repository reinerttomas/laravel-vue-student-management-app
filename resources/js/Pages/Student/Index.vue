<script setup>
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { formatDate } from '@vueuse/core';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, ref, watch } from 'vue';

defineProps({
  students: {
    type: Object,
    required: true,
  },
});

const pageNumber = ref(1);
const searchTerm = ref(usePage().props.search ?? '');

const pageNumberUpdated = (link) => {
  const url = new URL(link);
  const urlParams = new URLSearchParams(url.search);

  pageNumber.value = urlParams.get('page');
};

const studentsUrl = computed(() => {
  const url = new URL(route('students.index'));
  url.searchParams.append('page', pageNumber.value);

  if (searchTerm.value) {
    url.searchParams.append('search', searchTerm.value);
  }

  return url;
});

watch(
  () => studentsUrl.value,
  (newValue) => {
    router.visit(newValue, {
      preserveScroll: true,
      preserveState: true,
      replace: true,
    });
  }
);

const deleteForm = useForm({});

const deleteStudent = (id) => {
  if (confirm('Are you sure you want to delete this student?')) {
    deleteForm.delete(route('students.destroy', id));
  }
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
      >
        Students List
      </h2>
    </template>

    <div class="bg-gray-100 py-10">
      <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-xl font-semibold text-gray-900">Students</h1>
              <p class="mt-2 text-sm text-gray-700">
                A list of all the Students.
              </p>
            </div>

            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
              <Link
                :href="route('students.create')"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              >
                Add Student
              </Link>
            </div>
          </div>

          <div class="mt-6 flex flex-col justify-between sm:flex-row">
            <div class="relative col-span-3 text-sm text-gray-800">
              <div
                class="pointer-events-none absolute bottom-0 left-0 top-0 flex items-center pl-2 text-gray-500"
              >
                <Search />
              </div>

              <input
                v-model="searchTerm"
                type="text"
                placeholder="Search students data..."
                id="search"
                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
          </div>

          <div class="mt-8 flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div
                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
              >
                <div
                  class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                >
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          ID
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          Name
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          Email
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Class
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Section
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Created At
                        </th>
                        <th
                          scope="col"
                          class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                        ></th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr v-for="student in students.data" :key="student.id">
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          {{ student.id }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          {{ student.name }}
                        </td>
                        <td
                          class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                          {{ student.email }}
                        </td>
                        <td
                          class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                          {{ student.class.name }}
                        </td>
                        <td
                          class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                          {{ student.section.name }}
                        </td>
                        <td
                          class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                          {{
                            formatDate(
                              new Date(student.created_at),
                              'MMMM D, YYYY',
                              { locales: 'cs-CZ' }
                            )
                          }}
                        </td>

                        <td
                          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                        >
                          <Link
                            :href="route('students.edit', student.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                          >
                            Edit
                          </Link>
                          <button
                            @click="deleteStudent(student.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Pagination
                  :meta="students.meta"
                  :pageNumberUpdated="pageNumberUpdated"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
