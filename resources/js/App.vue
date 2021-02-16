<template>
    <div class="container mw-100">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="/" target="_blank"><img src="https://avatars.githubusercontent.com/u/12453415?s=60&v=4"></a><br>
            <span class="text-secondary">Reges Mendes' Code Test</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Application</router-link>
                    <router-link to="/about" class="nav-item nav-link">About</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
}
</script>