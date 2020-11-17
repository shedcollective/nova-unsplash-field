<template>
    <panel-item :field="field">

        <div slot="value">
            <div >
                <img class="rounded w-3/5"
                     :src="this.field.value" />
            </div>
        </div>

    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
