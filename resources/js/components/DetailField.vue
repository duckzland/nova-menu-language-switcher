<template>
    <panel-item :field="field">
        <div slot="value">
            <div class="flex language-menu-switcher-field">
                <div v-if="active && active.locale && active.label" class="flex w-full leading-tight form-active">
                    <div class="active-lang flex">
                        <country-flag :country="getFlag(active.locale)" size="normal" />
                        <span class="text">{{ active.label }}</span>
                    </div>
                </div>
                <div v-if="Object.keys(options).length > 0" class="form-actions flex">
                    <v-select :id="field.name"
                            :class="errorClasses" 
                            :placeholder="getPlaceholder"
                            :options="options" 
                            :value="null"
                            label="label"
                            clearable="false"
                            >
                        <template v-slot:option="option">
                             <router-link
                                v-if="option.id > 0"
                                :data-testid="`${option.locale}-${testId}-details-button`"
                                :dusk="`${option.locale}-details-button`"
                                class="
                                    cursor-pointer
                                    text-70
                                    hover:text-white
                                    ml-3
                                    mt-2
                                    inline-flex
                                    items-center
                                "
                                v-tooltip.click="__('Manage Menu Items for :lang', { lang: option.label })"
                                :to="{
                                    name: 'detail',
                                    params: {
                                        resourceName: resourceName,
                                        resourceId: option.id
                                    },
                                    query: {
                                        locale: option.locale,
                                        localeParentId: field.value.parent
                                    }
                                }"
                            >
                                <div class="options-lang flex">
                                    <country-flag :country="getFlag(option.locale)" size="normal" />
                                    <span class="text">{{ option.label }}</span>
                                </div>
                            </router-link>
                            <router-link
                                v-else
                                dusk="create-button"
                                class="
                                    cursor-pointer
                                    text-70
                                    hover:text-white
                                    ml-3
                                    mt-2
                                    inline-flex
                                    items-center
                                "
                                v-tooltip.click="__('Create New Menu for :lang', { lang: option.label })"
                                :to="{
                                    name: 'create',
                                    params: {
                                        resourceName: resourceName,
                                    },
                                    query: {
                                        viaResource: resourceName,
                                        viaResourceId: resourceId,
                                        viaRelationship: $route.query.viaRelationship,
                                        locale: option.locale,
                                        localeParentId: field.value.parent
                                    }
                                }"
                            >
                                <div class="options-lang flex">
                                    <country-flag :country="getFlag(option.locale)" size="normal" />
                                    <span class="text">{{ option.label }}</span>
                                </div>
                            </router-link>
  
                        </template>
                    </v-select>
                </div>
            </div>
        </div>
    </panel-item>
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
                options: [],
                isEditing: false,
            }
        },
        mounted() {
            for (const [locale, data] of Object.entries(this.field.value.locales)) {
                if ((this.field.value.active === locale)) {
                    this.active = {
                        label: data.label,
                        locale: locale
                    }
                }

                else {
                    this.options.push({ label: data.label, locale: locale, id: data.id });
                }
            }
        },

        computed: {
            console: () => console,
            getPlaceholder: function(el) {
                return el.field.placeholder;
            }
        },
    }
</script>
