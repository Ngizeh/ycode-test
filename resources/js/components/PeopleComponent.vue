<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="text-5xl text-custom-color font-bold mb-20">My Team</h1>
    <div class="grid grid-cols-2 gap-20">
      <div>
        <h2 class="text-xl mb-5">Add new team member</h2>
        <div
          class="bg-green-400 rounded text-gray-700 p-2 my-4 text-center text-sm"
          v-if="success"
        >
          Team member added successfully
        </div>
        <form class="space-y-5" @submit.prevent="submitForm">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700"
              >Name</label
            >
            <div class="mt-1">
              <input
                type="text"
                name="name"
                id="name"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 p-3 border rounded-md"
                placeholder="Calvin Hawkins"
                v-model="form.name"
              />
              <span v-if="errors.name" class="text-red-500 text-sm italics">{{
                errors.name[0]
              }}</span>
            </div>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700"
              >Email</label
            >
            <div class="mt-1">
              <input
                type="text"
                name="email"
                v-model="form.email"
                id="email"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 p-3 border rounded-md"
                placeholder="you@example.com"
              />
            </div>
            <span v-if="errors.email" class="text-red-500 text-sm italics">{{
              errors.email[0]
            }}</span>
          </div>
          <div>
            <label
              for="photo"
              class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
            >
              Photo
            </label>
            <div class="mt-1" @dragover.prevent @drop.prevent @drop="fileDrop">
              <div
                class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
              >
                <div class="space-y-1 text-center">
                  <img
                    v-bind:src="imagePreview"
                    class="w-12 h-12 mx-auto rounded"
                    v-show="showPreview"
                  />
                  <svg
                    v-show="!showPreview"
                    class="mx-auto h-12 w-12 text-gray-400"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 48 48"
                    aria-hidden="true"
                  >
                    <path
                      d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label
                      for="photo"
                      class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                    >
                      <span>Upload a file</span>
                      <input
                        id="photo"
                        name="photo"
                        type="file"
                        class="sr-only"
                        @change="onFileChange"
                      />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">JPG only up to 10MB</p>
                </div>
              </div>
            </div>
            <span v-if="errors.photo" class="text-red-500 text-sm italics">{{
              errors.photo[0]
            }}</span>
          </div>
          <div class="flex items-center">
            <button
              disabled
              v-if="submitting"
              class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-400"
            >
              <svg
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Submitting...
            </button>
            <button
              v-else
              type="submit"
              class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
      <div>
        <p v-if="loading">Loading team members...</p>
        <ul class="divide-y divide-gray-200">
          <li class="py-4 flex" v-for="(member, index) in people" :key="index">
            <img
              class="h-10 w-10 rounded-full"
              :src="member.photo"
              @error="defaultImage"
              alt=""
            />
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-900">
                {{ member.email }}
              </p>
              <p class="text-sm text-gray-500">{{ member.name }}</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    team: Array,
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        photo: "",
      },
      loading: true,
      imagePreview: false,
      showPreview: false,
      submitting: false,
      success: false,
      errors: "",
      people: this.team,
    };
  },
  methods: {
    onFileChange(event) {
      /**
       * Get uploaded file on change input submit and renders in the view
       * @type [file]
       */
      this.form.photo = event.target.files[0];
      this.reader();
    },
    reader() {
      /**
       * Reads the and display on the view and validates it
       * @type {FileReader}
       */
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.showPreview = true;
          this.imagePreview = reader.result;
        }.bind(this),
        false
      );
      if (this.form.photo) {
        if (/\.(jpg)$/i.test(this.form.photo.name)) {
          reader.readAsDataURL(this.form.photo);
        }
      }
    },
    fileDrop(e) {
      /**
       * Drags and drop the file
       * @type {File}
       */
      this.form.photo = e.dataTransfer.files[0];
      this.reader();
    },
    submitForm() {
      /**
       * Submitting the form and gives the view feedback
       * @type {boolean}
       */
      this.submitting = true;
      let data = new FormData();
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      data.append("name", this.form.name);
      data.append("email", this.form.email);
      data.append("photo", this.form.photo);
      axios
        .post("/people", data, config)
        .then((response) => {
          this.errors = "";
          this.success = true;
          setTimeout(() => {
            this.form = {};
            this.success = false;
            this.showPreview = false;
          }, 4000);
          this.submitting = false;
          this.refreshData();
        })
        .catch((error) => {
          this.submitting = false;
          this.errors = error.response.data.errors;
        });
    },
    defaultImage(e) {
      /**
       * Path for default image in case of there's no image found
       * @type {string}
       */
      e.target.src = "../images/default.png";
    },
    refreshData() {
      /**
       * Gets the data from Airtable API
       * @type [array]
       */
      axios.get("/").then((response) => {
        this.people = response.data;
      });
    },
  },
  mounted() {
     /**
       * Loading the data on Application when component is mounted
       * @type {boolean, array}
       */
    this.loading = false;
    this.refreshData();
  },
  watch: {},
};
</script>
