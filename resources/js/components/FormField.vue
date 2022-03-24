<template>
    <default-field :field="field" :show-help-text="showHelpText" full-width-content>
        <template slot="field">
            <div class="flex language-menu-switcher-field">
                <div v-if="active && active.locale && active.label" class="flex w-full leading-tight form-active">
                    <div class="active-lang flex">
                        <country-flag :country="getFlag(active.locale)" size="normal" />
                        <span class="text">{{ active.label }}</span>
                    </div>
                </div>
                <div v-if="field.value.id" class="form-actions flex">         
                    <router-link
                        :data-testid="`${testId}-view-button`"
                        :dusk="`${field.value.id}-view-button`"
                        class="
                            cursor-pointer
                            text-70
                            hover:text-primary
                            ml-3
                            mt-2
                            inline-flex
                            items-center
                        "
                        v-tooltip.click="__('Manage Menu Items')"
                        :to="{
                            name: 'detail',
                            params: {
                                resourceName: resourceName,
                                resourceId: field.value.id
                            },
                            query: {
                                locale: field.value.active,
                                localeParentId: field.value.parent
                            }
                        }"
                    >
                        <icon type="view" width="22" height="18" view-box="0 0 22 16" />
                    </router-link>
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova'
    import { global } from '../mixin/global'

    export default {
        mixins: [ FormField, HandlesValidationErrors, global ],

        props:  ['resource', 'resourceName', 'resourceId', 'field'],

        data: function () {
            return {
                active: {},
                isEditing: false,
            }
        },
        mounted() {

            if (!this.field.value.active) {
                this.field.value.active = this.getParams('locale') || this.field.value.fallback;
            }

            for (const [locale, data] of Object.entries(this.field.value.locales)) {
                if (this.field.value.active === locale) {
                    this.active = {
                        label: data.label,
                        locale: locale
                    }
                }
            }
        },

        computed: {
            console: () => console
        },
    }
</script>
