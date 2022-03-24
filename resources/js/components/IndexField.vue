<template>
    <div class="inline-flex">
        <tooltip trigger="click">
            <div class="text-primary inline-flex items-center dim cursor-pointer">
                <span class="text-primary font-bold">{{ __("View") }}</span>
            </div>
            <tooltip-content slot="content" class="language-menu-switcher-tooltip">
                <ul class="list-reset language-menu-switcher-field">
                    <li v-bind:key="option.locale" v-for="option in options" class="mb-1 form-actions">
                        <router-link
                            v-if="option.id > 0"
                            :data-testid="`${testId}-view-button`"
                            :dusk="`${field.value.id}-view-button`"
                            class="
                                cursor-pointer
                                text-70
                                ml-3
                                mt-2
                                inline-flex
                                items-center
                            "
                            v-tooltip.click="__('Manage menu items for :lang', { lang: option.label})"
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
                                ml-3
                                mt-2
                                inline-flex
                                items-center
                            "
                            v-tooltip.click="__('Create new menu for :lang', { lang: option.label})"
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
                    </li>
                </ul>
            </tooltip-content>
        </tooltip>
    </div>
</template>

<script>
    import { global } from '../mixin/global'
    export default {
        mixins: [ global ],
        props: ['resource', 'resourceName', 'resourceId', 'field'],

        data: () => ({
            options: []
        }),

        created() {
            for (const [locale, data] of Object.entries(this.field.value.locales)) {
                this.options.push({ label: data.label, locale: locale, id: data.id });
            }
        },

        computed: {
            console: () => console,
        },
    };
</script>
