<template>
    <default-field :field="field" :errors="errors" :fullWidthContent=true>
        <template slot="field">
            <div class="flex items-center py-1 w-3/5">
                <input v-model="query" type="text" :placeholder="field.queryPlaceholder"
                       class="mb-4 w-full form-control form-input form-input-bordered">
                <a @click="searchPhotos()" class="mb-4 ml-1 btn btn-default btn-primary cursor-pointer">Search</a>
            </div>

            <div class="mb-6 text-80" v-if="nothingFound">
                Unsplash could not find anything on your request. Please try another one.
            </div>

            <div class="mb-6" v-if="photos.length">
                <a @click="selectPhoto(photo)" class="cursor-pointer w-1/5 pr-1" v-for="photo in photos">
                    <img :src="photo.urls.thumb">
                </a>

                <a @click="searchPrev()" v-if="hasPrev"
                    class="btn btn-default btn-primary cursor-pointer">
                    Prev
                </a>
                <a v-else
                    class="btn btn-default btn-primary opacity-50 cursor-not-allowed">
                    Prev
                </a>

                <a @click="searchNext()" v-if="hasNext"
                    class="ml-1 btn btn-default btn-primary cursor-pointer">
                    Next
                </a>
                <a v-else
                    class="ml-1 btn btn-default btn-primary cursor-pointer">
                    Next
                </a>
            </div>

            <div class="mb-6 text-80">Or you can directly specify an image url</div>

            <input
                :id="field.name"
                type="text"
                class="w-3/5 form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="field.name"
                v-model="value"
            />

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            query: '',
            page: 1,
            photos: [],
            total: false,
        }
    },

    computed: {
        hasPrev: function () {
            return this.page > 1;
        },
        hasNext: function () {
            return this.page <= this.total;
        },
        nothingFound: function () {
            return this.query != '' && this.total === 0;
        },
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },

        searchPhotos() {

            axios.get(`https://api.unsplash.com/search/photos/?client_id=${this.field.unsplashKey}&query=${this.query}&orientation=portrait&featured=${this.field.featured}&per_page=8&page=${this.page}`)
                .then(response => {
                    this.photos = response.data.results;
                    this.total = response.data.total;
                })
                .catch(e => {
                    this.photos = [];
                })
        },

        searchNext() {
            this.page = this.page + 1;
            this.searchPhotos();
        },

        searchPrev() {
            this.page = this.page - 1;
            this.searchPhotos();
        },

        selectPhoto(photo) {
            this.value = photo.urls.regular;
        },
    },
}
</script>
