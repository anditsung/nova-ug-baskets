<template>
    <loading-view :loading="loading">
        <form
            @submit="submitViaGenerateLabel"
            autocomplete="off"
            ref="form"
        >
            <heading :level="1" class="mb-3">{{__("Basket Label")}}</heading>

            <card class="mb-8">
                <component
                    :class="{
                        'remove-bottom-border': index == fields.length - 1,
                    }"
                    v-for="(field, index) in fields"
                    :key="index"
                    :is="`${mode}-${field.component}`"
                    :errors="validationErrors"
                    :field="field"
                />
            </card>

            <div class="flex items-center justify-end">
                <progress-button
                    dusk="create-button"
                    type="submit"
                    :disabled="isWorking"
                    :processing="wasSubmittedViaGenerateLabel"
                >
                    {{__("Generate Label")}}
                </progress-button>
            </div>

        </form>
    </loading-view>
</template>

<script>
    import { Errors, Minimum, InteractsWithResourceInformation } from 'laravel-nova'

    export default {
        mixins: [ InteractsWithResourceInformation ],

        props: {
            mode: {
                type: String,
                default: 'form',
            },
            resourceName: {
                default: '',
            },
            viaResource: {
                default: '',
            },
            viaResourceId: {
                default: '',
            },
            viaRelationship: {
                default: '',
            },
        },

        data: () => ({
            loading: true,
            submittedViaGenerateLabel: false,
            fields: [],
            validationErrors: new Errors(),
            isWorking: false,
        }),

        async created() {
            this.getFields()
        },

        methods: {

            async getFields() {
                this.fields = []

                const { data: fields } = await Nova.request().get(
                    '/nova-vendor/nova-ug-baskets/fields'
                )

                this.fields = fields
                this.loading = false
            },

            async submitViaGenerateLabel(e) {
                e.preventDefault()
                this.submittedViaGenerateLabel = true
                await this.createResource()
            },

            async createResource() {
                this.isWorking = true

                if (this.$refs.form.reportValidity()) {
                    try {

                        const response = await this.createRequest()

                        let url = '/nova-ug-baskets/baskets/' + response.data

                        window.open(url, '_blank');

                        Nova.success(
                            this.__("Success"), {
                                type: 'success'
                            }
                        )

                        //this.getFields()

                        this.validationErrors = new Errors()
                        this.submittedViaGenerateLabel = false
                        this.isWorking = false

                    } catch (error) {
                        this.submittedViaGenerateLabel = false
                        this.isWorking = false

                        if(error.response.status == 422) {
                            this.validationErrors = new Errors(error.response.data.errors)
                            Nova.error(this.__('There was a problem submitting the form.'))
                        }
                    }
                }

                this.submittedViaGenerateLabel = false
                this.isWorking = false
            },

            createRequest() {
                return Nova.request().post(
                    '/nova-vendor/nova-ug-baskets/fields',
                    this.createRequestFormData()
                )
            },

            createRequestFormData() {
                return _.tap(new FormData(), formData => {
                    _.each(this.fields, field => {
                        field.fill(formData)
                    })
                })
            }
        },

        computed: {
            wasSubmittedViaGenerateLabel() {
                return this.isWorking && this.submittedViaGenerateLabel
            },

            isRelation() {
                return Boolean(this.viaResourceId && this.viaRelationship)
            },
        },
    }
</script>
