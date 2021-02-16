<template>
    <div class="row">
        <div class="col-md-8">Price Monitor</div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <price-monitor></price-monitor>
        </div>
    </div>
</template>

<script>
import PriceMonitor from '../js/components/PriceMonitor.vue';

export default {
    name: "Home",
    components: {
        PriceMonitor,
    },
    data() {
        return {
        };
    },
    methods: {
    },
    mounted() {
    },
    unmounted() {
    }
}
</script>