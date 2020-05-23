<template>

    <div class="buttons">
        <a :href="ajuda" class="button btn btnPrimary"> Ajuda </a>
        <!-- <a :href="idiomes" class="button btn btnPrimary"> Idiomes </a> -->
        <a :href="logout" class="button btn btnSecondary" @click="deleteCookieUser"> Sortir </a>
    </div>

</template>

<style>

.buttons {
    font-family: 'Montserrat', sans-serif;
    z-index: 999;
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
}

.btnPrimary, .btnSecondary {
    background: #F8FAFC;
    font-size: 1rem;
    border: 0;
}

</style>

<script>
    export default {
        data() {
            return {
                ajuda: 'ajuda',
                // idiomes: 'idiomes',
                logout: 'logout',
            }
        },

        methods: {
            deleteCookieUser: function() {
                document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }
        }
    }
</script>
